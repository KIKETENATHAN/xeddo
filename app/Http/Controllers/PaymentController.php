<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Services\MpesaService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $mpesaService;
    protected $receiptService;

    public function __construct(MpesaService $mpesaService, ReceiptService $receiptService)
    {
        $this->mpesaService = $mpesaService;
        $this->receiptService = $receiptService;
    }

    /**
     * Initiate booking and payment
     */
    public function initiateBooking(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'passenger_name' => 'required|string|max:255',
            'passenger_email' => 'required|email|max:255',
            'passenger_phone' => 'required|string|max:20',
            'seats' => 'integer|min:1|max:4',
        ]);

        try {
            DB::beginTransaction();

            $trip = Trip::with(['driver.user', 'sacco'])->findOrFail($request->trip_id);

            // Check if trip is still available
            if ($trip->status !== 'scheduled' || $trip->remaining_seats < ($request->seats ?? 1)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This trip is no longer available or doesn\'t have enough seats.'
                ], 400);
            }

            // Create booking
            $booking = Booking::create([
                'booking_reference' => Booking::generateBookingReference(),
                'user_id' => auth()->id() ?? null, // Allow guest bookings
                'trip_id' => $trip->id,
                'passenger_name' => $request->passenger_name,
                'passenger_email' => $request->passenger_email,
                'passenger_phone' => $request->passenger_phone,
                'amount' => $trip->amount * ($request->seats ?? 1),
                'seats_booked' => $request->seats ?? 1,
                'status' => 'pending',
                'booking_date' => now(),
            ]);

            // Create payment record
            $payment = Payment::create([
                'payment_reference' => Payment::generatePaymentReference(),
                'booking_id' => $booking->id,
                'phone_number' => $request->passenger_phone,
                'amount' => $booking->amount,
                'payment_method' => 'mpesa',
                'status' => 'pending',
            ]);

            // Initiate STK push
            $stkResult = $this->mpesaService->stkPush(
                $request->passenger_phone,
                $booking->amount,
                $booking
            );

            if ($stkResult['success']) {
                // Update payment with STK details
                $payment->update([
                    'checkout_request_id' => $stkResult['checkout_request_id'],
                    'merchant_request_id' => $stkResult['merchant_request_id'],
                    'status' => 'processing',
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Please complete payment on your phone',
                    'booking_reference' => $booking->booking_reference,
                    'payment_reference' => $payment->payment_reference,
                    'amount' => $booking->amount,
                    'checkout_request_id' => $stkResult['checkout_request_id'],
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $stkResult['message']
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking initiation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your booking.'
            ], 500);
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'checkout_request_id' => 'required|string',
        ]);

        try {
            $payment = Payment::where('checkout_request_id', $request->checkout_request_id)
                             ->with('booking.trip.driver.user', 'booking.trip.sacco')
                             ->first();

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not found'
                ], 404);
            }

            // Query M-Pesa for status
            $statusResult = $this->mpesaService->querySTKStatus($request->checkout_request_id);

            if ($statusResult['success']) {
                $data = $statusResult['data'];
                
                if (isset($data['ResultCode'])) {
                    if ($data['ResultCode'] == '0') {
                        // Payment successful
                        $payment->update([
                            'status' => 'completed',
                            'transaction_id' => $data['CallbackMetadata']['Item'][1]['Value'] ?? null,
                            'paid_at' => now(),
                            'payment_details' => $data,
                        ]);

                        $payment->booking->update([
                            'status' => 'confirmed'
                        ]);

                        // Update trip booked seats
                        $trip = $payment->booking->trip;
                        $trip->increment('booked_seats', $payment->booking->seats_booked);

                        // Reload booking with relationships for receipt
                        $booking = $payment->booking()->with(['trip.driver.user', 'trip.sacco'])->first();

                        // Generate receipt HTML
                        $receiptHtml = view('receipt', compact('booking'))->render();

                        return response()->json([
                            'success' => true,
                            'payment_status' => 'completed',
                            'message' => 'Payment completed successfully',
                            'receipt_data' => $receiptHtml,
                            'booking_reference' => $booking->booking_reference,
                        ]);
                    } else {
                        // Payment failed
                        $payment->update([
                            'status' => 'failed',
                            'payment_details' => $data,
                        ]);

                        $payment->booking->update([
                            'status' => 'cancelled'
                        ]);

                        return response()->json([
                            'success' => true,
                            'payment_status' => 'failed',
                            'message' => 'Payment was not completed'
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'payment_status' => $payment->status,
                'message' => 'Payment is still processing'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment status check error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking payment status'
            ], 500);
        }
    }

    /**
     * M-Pesa callback handler
     */
    public function mpesaCallback(Request $request)
    {
        try {
            Log::info('M-Pesa callback received', $request->all());

            $data = $request->all();
            
            if (isset($data['Body']['stkCallback'])) {
                $callback = $data['Body']['stkCallback'];
                $checkoutRequestId = $callback['CheckoutRequestID'];

                $payment = Payment::where('checkout_request_id', $checkoutRequestId)->first();

                if ($payment) {
                    if ($callback['ResultCode'] == '0') {
                        // Payment successful
                        $transactionId = null;
                        if (isset($callback['CallbackMetadata']['Item'])) {
                            foreach ($callback['CallbackMetadata']['Item'] as $item) {
                                if ($item['Name'] === 'MpesaReceiptNumber') {
                                    $transactionId = $item['Value'];
                                    break;
                                }
                            }
                        }

                        $payment->update([
                            'status' => 'completed',
                            'transaction_id' => $transactionId,
                            'paid_at' => now(),
                            'payment_details' => $callback,
                        ]);

                        $payment->booking->update([
                            'status' => 'confirmed'
                        ]);

                        // Update trip booked seats
                        $trip = $payment->booking->trip;
                        $trip->increment('booked_seats', $payment->booking->seats_booked);

                    } else {
                        // Payment failed
                        $payment->update([
                            'status' => 'failed',
                            'payment_details' => $callback,
                        ]);

                        $payment->booking->update([
                            'status' => 'cancelled'
                        ]);
                    }
                }
            }

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);

        } catch (\Exception $e) {
            Log::error('M-Pesa callback error: ' . $e->getMessage());
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Error']);
        }
    }

    /**
     * Get receipt
     */
    public function getReceipt($bookingReference)
    {
        try {
            $booking = Booking::where('booking_reference', $bookingReference)
                             ->with(['trip.driver.user', 'trip.sacco', 'payment'])
                             ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            if ($booking->payment->status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not completed'
                ], 400);
            }

            $receiptData = $this->receiptService->generateReceiptData($booking);

            return response()->json([
                'success' => true,
                'receipt' => $receiptData,
            ]);

        } catch (\Exception $e) {
            Log::error('Receipt generation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating receipt'
            ], 500);
        }
    }

    /**
     * Get receipt as HTML view
     */
    public function getReceiptView($bookingReference)
    {
        try {
            $booking = Booking::where('booking_reference', $bookingReference)
                             ->with(['trip.driver.user', 'trip.sacco', 'payment'])
                             ->first();

            if (!$booking) {
                abort(404, 'Booking not found');
            }

            if ($booking->payment->status !== 'completed') {
                abort(400, 'Payment not completed');
            }

            return view('receipt', compact('booking'));

        } catch (\Exception $e) {
            Log::error('Receipt view error: ' . $e->getMessage());
            abort(500, 'Error generating receipt');
        }
    }
}

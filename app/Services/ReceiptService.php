<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\View;

class ReceiptService
{
    /**
     * Generate receipt HTML
     */
    public function generateReceiptHtml(Booking $booking)
    {
        return View::make('receipts.booking-receipt', compact('booking'))->render();
    }

    /**
     * Generate receipt data for API response
     */
    public function generateReceiptData(Booking $booking)
    {
        return [
            'booking_reference' => $booking->booking_reference,
            'payment_reference' => $booking->payment->payment_reference ?? null,
            'passenger_name' => $booking->passenger_name,
            'passenger_email' => $booking->passenger_email,
            'passenger_phone' => $booking->passenger_phone,
            'trip_details' => [
                'from_location' => $booking->trip->from_location,
                'to_location' => $booking->trip->to_location,
                'departure_time' => $booking->trip->departure_time->format('Y-m-d H:i:s'),
                'driver_name' => $booking->trip->driver->user->name,
                'driver_phone' => $booking->trip->driver->user->phone ?? 'N/A',
                'vehicle_details' => $booking->trip->driver->vehicle_registration ?? 'N/A',
                'sacco_name' => $booking->trip->sacco->name,
            ],
            'payment_details' => [
                'amount' => $booking->amount,
                'seats_booked' => $booking->seats_booked,
                'payment_method' => $booking->payment->payment_method ?? 'mpesa',
                'transaction_id' => $booking->payment->transaction_id ?? null,
                'payment_status' => $booking->payment->status ?? 'pending',
                'paid_at' => $booking->payment->paid_at ? $booking->payment->paid_at->format('Y-m-d H:i:s') : null,
            ],
            'booking_date' => $booking->booking_date->format('Y-m-d H:i:s'),
            'booking_status' => $booking->status,
            'receipt_generated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Send receipt via email
     */
    public function sendReceiptEmail(Booking $booking)
    {
        // This would implement email sending logic
        // For now, we'll just return the receipt data
        return $this->generateReceiptData($booking);
    }
}

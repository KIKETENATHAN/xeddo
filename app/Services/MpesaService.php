<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $consumerKey;
    private $consumerSecret;
    private $shortcode;
    private $passkey;
    private $baseUrl;
    
    public function __construct()
    {
        $this->consumerKey = config('mpesa.consumer_key', 'your_consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret', 'your_consumer_secret');
        $this->shortcode = config('mpesa.shortcode', '174379');
        $this->passkey = config('mpesa.passkey', 'your_passkey');
        $this->baseUrl = config('mpesa.base_url', 'https://sandbox.safaricom.co.ke');
    }

    /**
     * Get access token from M-Pesa
     */
    public function getAccessToken()
    {
        try {
            $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
            
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            Log::error('M-Pesa token generation failed', $response->json());
            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa token generation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Initiate STK Push
     */
    public function stkPush($phoneNumber, $amount, Booking $booking)
    {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return ['success' => false, 'message' => 'Failed to get access token'];
            }

            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

            // Format phone number (remove + and ensure it starts with 254)
            $phone = $this->formatPhoneNumber($phoneNumber);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => $booking->booking_reference,
                'TransactionDesc' => 'Xeddo Ride Booking Payment'
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['ResponseCode']) && $data['ResponseCode'] == '0') {
                    return [
                        'success' => true,
                        'checkout_request_id' => $data['CheckoutRequestID'],
                        'merchant_request_id' => $data['MerchantRequestID'],
                        'message' => 'STK push sent successfully'
                    ];
                }
            }

            Log::error('M-Pesa STK push failed', $response->json());
            return ['success' => false, 'message' => 'Failed to initiate payment'];

        } catch (\Exception $e) {
            Log::error('M-Pesa STK push error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment service error'];
        }
    }

    /**
     * Query STK Push status
     */
    public function querySTKStatus($checkoutRequestId)
    {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return ['success' => false, 'message' => 'Failed to get access token'];
            }

            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/mpesa/stkpushquery/v1/query', $payload);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'message' => 'Query failed'];

        } catch (\Exception $e) {
            Log::error('M-Pesa query error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Query service error'];
        }
    }

    /**
     * Format phone number for M-Pesa
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it starts with 0, replace with 254
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If it doesn't start with 254, add it
        if (substr($phone, 0, 3) !== '254') {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }
}

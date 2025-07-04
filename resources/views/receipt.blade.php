<!DOCTYPE html>
<html>
<head>
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
        }
        .receipt {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .receipt-header h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 24px;
        }
        .receipt-header p {
            margin: 5px 0;
            color: #666;
        }
        .receipt-section {
            margin-bottom: 25px;
        }
        .receipt-section h3 {
            margin: 0 0 15px 0;
            color: #1e3a8a;
            font-size: 18px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .receipt-row:last-child {
            border-bottom: none;
        }
        .receipt-row.total {
            font-weight: bold;
            font-size: 18px;
            color: #1e3a8a;
            border-top: 2px solid #1e3a8a;
            margin-top: 15px;
            padding-top: 15px;
        }
        .receipt-row .label {
            color: #374151;
            font-weight: 500;
        }
        .receipt-row .value {
            color: #111827;
            font-weight: 600;
        }
        .receipt-status {
            text-align: center;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .receipt-status.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Xeddo Travel Link</h1>
            <p>Booking Receipt</p>
            <p>{{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="receipt-status success">
            BOOKING CONFIRMED
        </div>

        <div class="receipt-section">
            <h3>Booking Details</h3>
            <div class="receipt-row">
                <span class="label">Booking Reference:</span>
                <span class="value">{{ $booking->booking_reference }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Payment Reference:</span>
                <span class="value">{{ $booking->payment->payment_reference }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Booking Date:</span>
                <span class="value">{{ $booking->booking_date->format('F j, Y \a\t g:i A') }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Status:</span>
                <span class="value">{{ ucfirst($booking->status) }}</span>
            </div>
        </div>

        <div class="receipt-section">
            <h3>Passenger Information</h3>
            <div class="receipt-row">
                <span class="label">Name:</span>
                <span class="value">{{ $booking->passenger_name }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Email:</span>
                <span class="value">{{ $booking->passenger_email }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $booking->passenger_phone }}</span>
            </div>
        </div>

        <div class="receipt-section">
            <h3>Trip Information</h3>
            <div class="receipt-row">
                <span class="label">SACCO:</span>
                <span class="value">{{ $booking->trip->sacco->name }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Driver:</span>
                <span class="value">{{ $booking->trip->driver->user->name }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">License Number:</span>
                <span class="value">{{ $booking->trip->driver->license_number }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Route:</span>
                <span class="value">{{ $booking->trip->from_location }} → {{ $booking->trip->to_location }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Departure Date:</span>
                <span class="value">{{ $booking->trip->departure_time->format('F j, Y') }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Departure Time:</span>
                <span class="value">{{ $booking->trip->departure_time->format('g:i A') }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Vehicle:</span>
                <span class="value">{{ $booking->trip->vehicle_type ?? 'Standard' }}</span>
            </div>
        </div>

        <div class="receipt-section">
            <h3>Payment Information</h3>
            <div class="receipt-row">
                <span class="label">Seats Booked:</span>
                <span class="value">{{ $booking->seats_booked }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Price per Seat:</span>
                <span class="value">KES {{ number_format($booking->trip->amount, 2) }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Payment Method:</span>
                <span class="value">{{ ucfirst($booking->payment->payment_method) }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Transaction ID:</span>
                <span class="value">{{ $booking->payment->transaction_id ?? 'N/A' }}</span>
            </div>
            <div class="receipt-row">
                <span class="label">Payment Status:</span>
                <span class="value">{{ ucfirst($booking->payment->status) }}</span>
            </div>
            <div class="receipt-row total">
                <span class="label">Total Amount:</span>
                <span class="value">KES {{ number_format($booking->amount, 2) }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for choosing Xeddo Travel Link!</p>
            <p>For support, contact us at support@xeddo.com or call +254 700 000 000</p>
            <p>Please arrive at the pickup location at least 15 minutes before departure time.</p>
        </div>
    </div>

    <script>
        // Auto-print if requested
        if (window.location.search.includes('print=true')) {
            window.print();
        }
    </script>
</body>
</html>

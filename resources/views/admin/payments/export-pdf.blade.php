<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Report - Xeddo Travel Link</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
        }
        .summary-item h3 {
            margin: 0;
            color: #1e3a8a;
            font-size: 18px;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .filters {
            background-color: #e0e7ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            color: #1e3a8a;
        }
        .filters p {
            margin: 5px 0;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tr:hover {
            background-color: #f5f5f5;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-refunded {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .amount {
            font-weight: bold;
            color: #1e3a8a;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Xeddo Travel Link</h1>
        <h2>Payment Report</h2>
        <p>Generated on: {{ $exportDate }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary">
        <div class="summary-item">
            <h3>Total Payments</h3>
            <p>{{ number_format($totalPayments) }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Revenue</h3>
            <p>KSh {{ number_format($totalRevenue) }}</p>
        </div>
        <div class="summary-item">
            <h3>Completed</h3>
            <p>{{ number_format($completedPayments) }}</p>
        </div>
        <div class="summary-item">
            <h3>Pending</h3>
            <p>{{ number_format($pendingPayments) }}</p>
        </div>
        <div class="summary-item">
            <h3>Failed</h3>
            <p>{{ number_format($failedPayments) }}</p>
        </div>
    </div>

    <!-- Applied Filters -->
    @if(!empty(array_filter($filters)))
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if(!empty($filters['status']))
            <p><strong>Status:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
        @if(!empty($filters['payment_method']))
            <p><strong>Payment Method:</strong> {{ ucfirst($filters['payment_method']) }}</p>
        @endif
        @if(!empty($filters['date_from']))
            <p><strong>Date From:</strong> {{ $filters['date_from'] }}</p>
        @endif
        @if(!empty($filters['date_to']))
            <p><strong>Date To:</strong> {{ $filters['date_to'] }}</p>
        @endif
    </div>
    @endif

    <!-- Payment Details Table -->
    @if($payments->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Payment Ref</th>
                    <th>Transaction ID</th>
                    <th>Passenger</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Route</th>
                    <th>SACCO</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_reference }}</td>
                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
                        <td>{{ $payment->phone_number }}</td>
                        <td class="amount">KSh {{ number_format($payment->amount) }}</td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td>
                            <span class="status status-{{ $payment->status }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>
                            @if($payment->booking && $payment->booking->trip)
                                {{ $payment->booking->trip->from_location }} → {{ $payment->booking->trip->to_location }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($payment->booking && $payment->booking->trip && $payment->booking->trip->sacco)
                                {{ $payment->booking->trip->sacco->name }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>No Payment Data Found</h3>
            <p>No payments match the applied filters for the specified criteria.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated automatically by Xeddo Travel Link Admin System</p>
        <p>Report contains {{ number_format($payments->count()) }} payment records</p>
        @if($payments->count() > 0)
            <p>Success Rate: {{ $totalPayments > 0 ? number_format(($completedPayments / $totalPayments) * 100, 1) : 0 }}%</p>
        @endif
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Passengers Export - {{ date('M d, Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            font-size: 24px;
        }
        
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: #1e3a8a;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Passenger Export Report</h1>
        <p>Generated on {{ date('F d, Y \a\t g:i A') }}</p>
        <p>Xeddo Travel Link - Passenger Management System</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $passengers->count() }}</div>
            <div class="stat-label">Total Passengers</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $passengers->where('email_verified_at', '!=', null)->count() }}</div>
            <div class="stat-label">Active Passengers</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $passengers->where('email_verified_at', null)->count() }}</div>
            <div class="stat-label">Inactive Passengers</div>
        </div>
    </div>

    @if($passengers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Name</th>
                    <th style="width: 30%">Email</th>
                    <th style="width: 20%">Phone</th>
                    <th style="width: 20%">Registration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($passengers as $index => $passenger)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $passenger->name }}</td>
                        <td>{{ $passenger->email }}</td>
                        <td>{{ $passenger->phone }}</td>
                        <td>{{ $passenger->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            No passengers found matching the selected criteria.
        </div>
    @endif

    <div class="footer">
        <p>© {{ date('Y') }} Xeddo Travel Link - Confidential Document</p>
    </div>
</body>
</html>

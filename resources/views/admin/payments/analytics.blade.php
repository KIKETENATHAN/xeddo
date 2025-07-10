<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Analytics - Xeddo Travel Link</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
        }

        .bg-primary { background-color: var(--primary-navy); }
        .bg-secondary { background-color: var(--secondary-gold); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-navy-dark) 100%);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(245, 158, 11, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 50px rgba(30, 58, 138, 0.4);
        }

        .stat-card.revenue {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.payments {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .stat-card.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-card.failed {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .stat-card.refunded {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .stat-card.average {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: var(--primary-navy);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-navy-dark);
        }

        .btn-secondary {
            background-color: var(--secondary-gold);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-gold-dark);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation Header -->
        <nav class="bg-primary shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                            <img src="{{ asset('images/xeddo-logo.png') }}" alt="Xeddo" class="h-8 w-auto">
                            <span class="text-white font-bold text-xl">Admin Panel</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.payments.index') }}" class="text-white hover:text-secondary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-secondary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <nav class="text-sm breadcrumbs mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-primary">Admin</a>
                            <span class="text-gray-400 mx-2">/</span>
                            <a href="{{ route('admin.payments.index') }}" class="text-gray-500 hover:text-primary">Payments</a>
                            <span class="text-gray-400 mx-2">/</span>
                            <span class="text-primary">Analytics</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-primary">Payment Analytics</h1>
                        <p class="text-gray-600 mt-2">Comprehensive payment insights and statistics</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.payments.index') }}" class="action-button btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Payments
                        </a>
                        <a href="{{ route('admin.payments.export', ['format' => 'pdf']) }}" class="action-button btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                <div class="stat-card revenue text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Total Revenue</p>
                            <p class="text-3xl font-bold">KSh {{ number_format($totalRevenue) }}</p>
                        </div>
                        <div class="text-green-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card payments text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Total Payments</p>
                            <p class="text-3xl font-bold">{{ number_format($totalPayments) }}</p>
                        </div>
                        <div class="text-blue-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card pending text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm">Pending</p>
                            <p class="text-3xl font-bold">{{ number_format($pendingPayments) }}</p>
                        </div>
                        <div class="text-yellow-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card failed text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm">Failed</p>
                            <p class="text-3xl font-bold">{{ number_format($failedPayments) }}</p>
                        </div>
                        <div class="text-red-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card refunded text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Refunded</p>
                            <p class="text-2xl font-bold">KSh {{ number_format($refundedAmount) }}</p>
                        </div>
                        <div class="text-purple-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card average text-white p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-100 text-sm">Avg Payment</p>
                            <p class="text-2xl font-bold">KSh {{ number_format($averagePayment) }}</p>
                        </div>
                        <div class="text-cyan-100">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7,13H11V7H13V13H17V15H13V21H11V15H7V13Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Payment Status Distribution -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-primary mb-4">Payment Status Distribution</h3>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-primary mb-4">Payment Methods</h3>
                    <div class="chart-container">
                        <canvas id="methodChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue Trends -->
            <div class="card p-6 mb-8">
                <h3 class="text-xl font-semibold text-primary mb-4">Daily Revenue Trend (Last 30 Days)</h3>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Monthly Statistics -->
            <div class="card p-6">
                <h3 class="text-xl font-semibold text-primary mb-4">Monthly Payment Statistics</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Payments</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Successful</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failed</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Success Rate</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payments_by_month as $month)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ DateTime::createFromFormat('!m', $month->month)->format('F') }} {{ $month->year }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($month->count) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ number_format($month->successful_count) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ number_format($month->failed_count) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">KSh {{ number_format($month->revenue) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $month->count > 0 ? number_format(($month->successful_count / $month->count) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($payments_by_status->pluck('status')->map(function($status) { return ucfirst($status); })),
                datasets: [{
                    data: @json($payments_by_status->pluck('count')),
                    backgroundColor: [
                        '#10b981', // completed - green
                        '#f59e0b', // pending - yellow
                        '#ef4444', // failed - red
                        '#8b5cf6', // refunded - purple
                        '#3b82f6', // processing - blue
                        '#6b7280'  // cancelled - gray
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Payment Methods Chart
        const methodCtx = document.getElementById('methodChart').getContext('2d');
        new Chart(methodCtx, {
            type: 'bar',
            data: {
                labels: @json($payments_by_method->pluck('payment_method')->map(function($method) { return ucfirst($method); })),
                datasets: [{
                    label: 'Revenue',
                    data: @json($payments_by_method->pluck('revenue')),
                    backgroundColor: '#1e3a8a',
                    borderColor: '#1e40af',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KSh ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Daily Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($daily_revenue->pluck('date')),
                datasets: [{
                    label: 'Daily Revenue',
                    data: @json($daily_revenue->pluck('revenue')),
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KSh ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>

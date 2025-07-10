<?php

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

$driver = config('database.default');
echo "Database driver: $driver" . PHP_EOL;

$paymentCount = Payment::count();
echo "Total payments: $paymentCount" . PHP_EOL;

try {
    if ($driver === 'sqlite') {
        $result = Payment::select(
            DB::raw('strftime("%Y", created_at) as year'),
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('COUNT(*) as count')
        )->groupBy('year', 'month')->first();
        echo "SQLite date function test: SUCCESS" . PHP_EOL;
        if ($result) {
            echo "Sample result - Year: {$result->year}, Month: {$result->month}, Count: {$result->count}" . PHP_EOL;
        }
    } else {
        echo "Using MySQL date functions" . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

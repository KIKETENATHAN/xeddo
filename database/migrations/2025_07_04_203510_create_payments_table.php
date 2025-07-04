<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_reference')->unique();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('mpesa');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('checkout_request_id')->nullable(); // For M-Pesa STK
            $table->string('merchant_request_id')->nullable(); // For M-Pesa STK
            $table->json('payment_details')->nullable(); // Store gateway response
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

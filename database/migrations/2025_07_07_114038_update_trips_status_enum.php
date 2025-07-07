<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table with the new enum values
        // First, create a temporary table with the new schema
        Schema::create('trips_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained('driver_profiles')->onDelete('cascade');
            $table->foreignId('sacco_id')->constrained('saccos')->onDelete('cascade');
            $table->string('from_location');
            $table->string('to_location');
            $table->datetime('departure_time');
            $table->datetime('estimated_arrival_time');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending_acceptance', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('pending_acceptance');
            $table->integer('available_seats')->default(0);
            $table->integer('booked_seats')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO trips_temp SELECT * FROM trips');

        // Drop the old table
        Schema::dropIfExists('trips');

        // Rename the temp table to the original name
        Schema::rename('trips_temp', 'trips');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the process
        Schema::create('trips_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('driver_profiles')->onDelete('cascade');
            $table->foreignId('sacco_id')->constrained('saccos')->onDelete('cascade');
            $table->string('from_location');
            $table->string('to_location');
            $table->datetime('departure_time');
            $table->datetime('estimated_arrival_time');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->integer('available_seats')->default(0);
            $table->integer('booked_seats')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Copy data from trips to temp table, excluding pending_acceptance status
        DB::statement("INSERT INTO trips_temp SELECT * FROM trips WHERE status != 'pending_acceptance'");

        // Drop the current table
        Schema::dropIfExists('trips');

        // Rename temp table back
        Schema::rename('trips_temp', 'trips');
    }
};

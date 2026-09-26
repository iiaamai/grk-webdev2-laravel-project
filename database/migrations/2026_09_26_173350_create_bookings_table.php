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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('driver_id')->nullable()->constrained('users');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
            $table->string('vehicle_type');
            $table->timestamp('booking_datetime');
            $table->date('posting_date')->nullable();
            $table->string('pickup_address');
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);
            $table->string('dropoff_address');
            $table->decimal('dropoff_lat', 10, 7);
            $table->decimal('dropoff_lng', 10, 7);
            $table->text('cargo_desc')->nullable();
            $table->text('additional_requirements')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('is_locked')->default(false);
            $table->timestamp('accepted_at')->nullable();
            $table->decimal('payout', 12, 2)->nullable();
            $table->string('gatepass_path')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'is_locked']);
            $table->index('vehicle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

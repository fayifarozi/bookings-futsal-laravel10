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
        Schema::create('detail_bookings', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id');
            $table->foreignId('field_id')->constrained('futsal_fields', 'field_id');
            $table->date('date_booked');
            $table->time('start_time');
            $table->integer('duration');
            $table->time('end_time');
            $table->decimal('price', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->string('metode')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_bookings');
    }
};

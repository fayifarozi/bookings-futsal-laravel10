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
        Schema::create('futsal_fields', function (Blueprint $table) {
            $table->id('field_id');
            $table->string('field_name');
            $table->string('description');
            $table->string('path');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['deactive', 'active'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('futsal_fields');
    }
};

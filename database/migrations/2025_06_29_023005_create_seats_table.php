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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theater_id')->constrained()->onDelete('cascade');
            $table->integer('row_number');
            $table->integer('seat_number');
            $table->enum('seat_type', ['regular', 'premium', 'vip'])->default('regular');
            $table->boolean('is_occupied')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Ensure unique seat per theater
            $table->unique(['theater_id', 'row_number', 'seat_number']);

            // Add indexes for performance
            $table->index(['theater_id', 'is_available', 'is_occupied']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};

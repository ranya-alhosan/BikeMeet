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
        Schema::create('user_rentals', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade'); // Foreign key to motorcycles table
            $table->foreignId('rent_id')->constrained()->onDelete('cascade'); // Foreign key to rentals table
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active'); // Rental status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rentals');
    }
};

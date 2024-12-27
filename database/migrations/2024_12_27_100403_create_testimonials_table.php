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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->unsignedBigInteger('user_id'); // foreign key for users table
            $table->enum('role', ['Motorcycle Lover', 'Motorcycle Renter', 'Event Organizer']); // dropdown list for roles
            $table->text('text'); // text column for the testimonial message
            $table->enum('status', ['Accept', 'Reject'])->default('Reject'); // status column (Accept/Reject)
            $table->timestamps(); // created_at and updated_at timestamps

            // Set foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->enum('availability_status', ['under_maintenance', 'available'])->default('available')->change(); // Set default as 'available'
        });
    }

    public function down()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->string('availability_status')->change(); // Revert to string if needed
        });
    }

};
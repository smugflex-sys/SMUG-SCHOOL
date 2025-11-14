<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // This is a pivot table to assign a student to a specific bus
        Schema::create('student_transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->enum('pickup_status', ['pending', 'onboard', 'dropped_off'])->default('pending');
            $table->timestamps();

            $table->unique(['student_id', 'bus_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_transport');
    }
};
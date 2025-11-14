<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exeat_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->comment('Parent User ID')->constrained('users')->onDelete('cascade');
            $table->text('reason');
            $table->dateTime('departure_time');
            $table->dateTime('expected_return_time');
            $table->enum('status', ['pending', 'approved', 'denied', 'completed'])->default('pending');
            $table->text('admin_remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->string('token')->unique(); // For QR code and public verification URL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exeat_requests');
    }
};
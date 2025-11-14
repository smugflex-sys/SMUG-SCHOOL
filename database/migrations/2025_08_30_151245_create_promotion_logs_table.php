<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('to_class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('from_session_id')->constrained('academic_sessions')->onDelete('cascade');
            $table->foreignId('to_session_id')->constrained('academic_sessions')->onDelete('cascade');
            $table->enum('status', ['promoted', 'repeated']);
            $table->decimal('final_average', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_logs');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_subject_teacher', function (Blueprint $table) {
            $table->id();
            // This links to the specific class-subject combination
            $table->foreignId('class_subject_id')->constrained('class_subject')->onDelete('cascade');
            // This links to the staff member (teacher)
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['class_subject_id', 'staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_subject_teacher');
    }
};
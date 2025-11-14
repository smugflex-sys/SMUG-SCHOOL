<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grading_systems', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name'); // e.g., A, B, C
            $table->integer('mark_from'); // e.g., 75
            $table->integer('mark_to'); // e.g., 100
            $table->string('remark'); // e.g., Excellent, Good
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading_systems');
    }
};
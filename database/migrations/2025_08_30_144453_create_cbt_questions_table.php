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
        Schema::create('cbt_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->comment('The teacher who created the question')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->json('options')->comment('Stores options like {"A": "Option A", "B": "Option B"}');
            $table->string('correct_answer')->comment('Stores the key of the correct option, e.g., "A"');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbt_questions');
    }
};
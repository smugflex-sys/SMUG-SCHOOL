<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('domain_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // 1-5 scale
            $table->timestamps();
            $table->unique(['student_id', 'term_id', 'domain_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('domain_ratings'); }
};
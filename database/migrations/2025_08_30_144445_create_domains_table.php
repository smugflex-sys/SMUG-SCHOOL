<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Punctuality", "Neatness"
            $table->string('type'); // "affective" or "psychomotor"
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('domains'); }
};
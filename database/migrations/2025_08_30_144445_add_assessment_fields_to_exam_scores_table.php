<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('exam_scores', function (Blueprint $table) {
            // To differentiate between CA1, CA2, CA3, and Final Exam scores
            $table->string('score_type')->default('exam')->after('exam_type_id');
        });
    }
    public function down(): void {
        Schema::table('exam_scores', function (Blueprint $table) {
            $table->dropColumn('score_type');
        });
    }
};
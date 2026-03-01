<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->foreignId('correct_option_id')->nullable()->after('answer_image')->constrained('quiz_question_options')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropForeign(['correct_option_id']);
        });
    }
};

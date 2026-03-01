<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_type_id')->constrained('quiz_types')->cascadeOnDelete();
            $table->string('name');
            $table->string('memory_page_image')->nullable()->comment('Full memory page grid image');
            $table->unsignedInteger('quiz_time')->default(0)->comment('Time in seconds to view memory page / complete quiz');
            $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_masters');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_masters', function (Blueprint $table) {
            $table->unsignedInteger('memory_time')->default(0)->after('memory_page_image')
                ->comment('Time in seconds to view memory page image');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_masters', function (Blueprint $table) {
            $table->dropColumn('memory_time');
        });
    }
};

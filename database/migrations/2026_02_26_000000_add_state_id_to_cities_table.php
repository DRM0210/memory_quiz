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
        if (!Schema::hasTable('cities')) {
            return;
        }

        if (!Schema::hasColumn('cities', 'state_id')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->unsignedBigInteger('state_id')->nullable()->after('id');
            });
            // Optional: add foreign key only if states table exists
            if (Schema::hasTable('states')) {
                Schema::table('cities', function (Blueprint $table) {
                    $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cities') && Schema::hasColumn('cities', 'state_id')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropForeign(['state_id']);
            });
            Schema::table('cities', function (Blueprint $table) {
                $table->dropColumn('state_id');
            });
        }
    }
};

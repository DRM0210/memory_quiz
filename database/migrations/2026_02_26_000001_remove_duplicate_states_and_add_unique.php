<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('states')) {
            return;
        }

        // Find duplicate state names and keep the one with smallest id
        $duplicates = DB::table('states')
            ->select('name', DB::raw('MIN(id) as keep_id'), DB::raw('GROUP_CONCAT(id) as ids'))
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $row) {
            $keepId = $row->keep_id;
            $ids = array_map('intval', explode(',', $row->ids));
            $deleteIds = array_filter($ids, fn($id) => $id != $keepId);

            if (Schema::hasTable('cities') && Schema::hasColumn('cities', 'state_id')) {
                DB::table('cities')
                    ->whereIn('state_id', $deleteIds)
                    ->update(['state_id' => $keepId]);
            }

            DB::table('states')->whereIn('id', $deleteIds)->delete();
        }

        // Add unique index on name to prevent future duplicates
        if (Schema::hasTable('states')) {
            Schema::table('states', function (Blueprint $table) {
                $table->unique('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('states')) {
            Schema::table('states', function (Blueprint $table) {
                $table->dropUnique(['name']);
            });
        }
    }
};

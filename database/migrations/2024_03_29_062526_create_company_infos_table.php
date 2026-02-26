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
        Schema::create('company_infos', function (Blueprint $table) {
          $table->id();
          $table->integer('user_id')->default(0);
          $table->string('name')->nullable();
          $table->string('email')->nullable();
          $table->string('phone')->nullable();
          $table->string('website')->nullable();
          $table->string('mobile')->nullable();
          $table->string('address')->nullable();
          $table->string('logo')->nullable();
          $table->string('icon')->nullable();
          $table->enum('status', ['1', '0'])->default('1');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};

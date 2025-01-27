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
        Schema::create('csrf_sessions', function (Blueprint $table) {
            $table->string('ip_address', 45)->primary();
            $table->string('csrf_token', 35)->unique();
            $table->integer('usage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csrf_sessions');
    }
};

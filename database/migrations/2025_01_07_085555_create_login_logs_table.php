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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('name')->index()->change();
        });

        Schema::create('login_logs', function (Blueprint $table) {
            $table->char('id', 24)->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('token_name')->unique();
            $table->string('ip_address', 45)->nullable();
            $table->string('fingerprint')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamps();

            $table->foreign('token_name')->references('name')->on('personal_access_tokens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('name')->change();
        });

        Schema::dropIfExists('login_logs');
    }
};

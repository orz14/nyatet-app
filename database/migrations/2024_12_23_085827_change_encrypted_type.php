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
        Schema::table('todos', function (Blueprint $table) {
            $table->longText('content')->change();
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->longText('title')->nullable()->change();
            $table->longText('note')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->text('content')->change();
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('note')->change();
        });
    }
};

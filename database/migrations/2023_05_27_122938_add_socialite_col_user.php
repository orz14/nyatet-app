<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function ($table) {

            $table->string('github_id')->nullable()->after('role_id');
            $table->string('google_id')->nullable()->after('github_id');
            $table->string('avatar')->nullable()->after('google_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('github_id');
            $table->dropColumn('google_id');
            $table->dropColumn('avatar');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_plans', function (Blueprint $table) {
            // Add new fields
            $table->timestamp('expired_at')->nullable()->after('ends_at');
            $table->boolean('is_expired')->default(false)->after('expired_at');
        });

        // Add unique constraint to ensure only one active plan per user
        // We need to use a raw SQL statement because Laravel doesn't support partial unique indexes
        DB::statement('CREATE UNIQUE INDEX user_plans_user_active_unique ON user_plans (user_id, status) WHERE status = \'active\'');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_plans', function (Blueprint $table) {
            $table->dropColumn(['expired_at', 'is_expired']);
        });

        DB::statement('DROP INDEX IF EXISTS user_plans_user_active_unique');
    }
};

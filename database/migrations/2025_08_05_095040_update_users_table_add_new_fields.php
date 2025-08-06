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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['admin', 'customer', 'company'])->default('customer')->after('email_verified_at');
            $table->text('fcm_token')->nullable()->after('type'); // Firebase Cloud Messaging token
            $table->boolean('is_active')->default(true)->after('fcm_token');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null')->after('is_active');
            $table->softDeletes()->after('updated_at');
            
            // Indexes for better performance
            $table->index('type');
            $table->index('is_active');
            $table->index('country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['country_id']);
            $table->dropIndex(['country_id']);
            $table->dropColumn(['type', 'fcm_token', 'is_active', 'country_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['is_active']);
        });
    }
};

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
        Schema::table('banners', function (Blueprint $table) {
            // Drop the index first if it exists
            if (Schema::hasColumn('banners', 'bannerable_id')) {
                $table->dropIndex(['bannerable_type', 'bannerable_id']);
            }
            
            // Remove polymorphic fields if they exist
            if (Schema::hasColumn('banners', 'bannerable_id')) {
                $table->dropColumn('bannerable_id');
            }
            if (Schema::hasColumn('banners', 'bannerable_type')) {
                $table->dropColumn('bannerable_type');
            }
            
            // Add new fields
            $table->unsignedBigInteger('model_id')->nullable()->after('external_link');
            $table->string('model')->nullable()->after('model_id')->comment('Model class name: Post, Department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn(['model_id', 'model']);
            
            // Add back polymorphic fields
            $table->unsignedBigInteger('bannerable_id')->nullable();
            $table->string('bannerable_type')->nullable();
        });
    }
};

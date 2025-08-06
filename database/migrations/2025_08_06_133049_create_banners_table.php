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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['post', 'department', 'external_link', 'none'])->default('none');
            $table->string('external_link')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Polymorphic relation fields
            $table->morphs('bannerable'); // Creates bannerable_id and bannerable_type columns
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

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
        Schema::create('offensive_words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->unique();
            $table->text('description')->nullable();
            $table->enum('severity', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['word']);
            $table->index(['severity']);
            $table->index(['is_active']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offensive_words');
    }
}; 
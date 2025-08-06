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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('company')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->text('address')->nullable();
            $table->unsignedBigInteger('number_of_views')->default(0);
            $table->string('activity')->nullable();
            $table->string('phone')->nullable();
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('currency', ['د.ل', 'دولار', 'يورو'])->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('department_id');
            $table->index('city_id');
            $table->index('country_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('number_of_views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

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
        Schema::create('work_shop_category', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Name of the category
            $table->string('slug', 255)->unique()->charset('utf8'); // Slug (unique value for URL), max length of 255 characters
            $table->string('meta_title')->nullable(); // Meta title (nullable if not required)
            $table->text('description')->nullable(); // Description (nullable if not required)
            $table->string('keywords')->nullable(); // Keywords (nullable as it might not always be required)
            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shop_category');
    }
};

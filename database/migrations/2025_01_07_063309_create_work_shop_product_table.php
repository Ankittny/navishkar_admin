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
        Schema::create('work_shop_product', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key, usually good to have
            $table->string('title'); // Title of the product
            $table->foreignId('cat_id')->constrained()->onDelete('cascade'); // Foreign key for category (assuming it links to another table)
            $table->string('image')->nullable(); // Image path for the product (nullable)
            $table->string('slug', 255)->unique()->charset('utf8'); 
            $table->text('meta_description')->nullable(); // Meta description (nullable)
            $table->string('meta_title')->nullable(); // Meta title (nullable)
            $table->string('keywords')->nullable(); // SEO keywords (nullable)
            $table->text('description'); // Full description of the product
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shop_product');
    }
};

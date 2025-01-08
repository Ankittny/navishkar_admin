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
            $table->id();
            $table->string('title');
            $table->foreignId('cat_id')->nullable()->constrained('work_shop_category')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('slug', 255)->unique()->charset('utf8');
            $table->text('meta_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description');
            $table->timestamps();
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

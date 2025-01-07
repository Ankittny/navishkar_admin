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
        Schema::table('work_shop_category', function (Blueprint $table) {
            $table->text('short_description')->nullable(); // Add nullable text field for short_description
            $table->text('operative')->nullable(); // Add nullable text field for operative
            $table->string('cover_pic')->nullable(); // Add nullable string field for cover_pic
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_shop_category', function (Blueprint $table) {
            // Drop the columns added in the up() method
            $table->dropColumn(['short_description', 'operative', 'cover_pic']);
        });
    }
};

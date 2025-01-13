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
        Schema::create('be_partner_with_us', function (Blueprint $table) {
            $table->id();
            $table->string('oraganization_name');
            $table->string('location');
            $table->string('contact_number');
            $table->string('official_email');
            $table->string('querry_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('be_partner_with_us');
    }
};

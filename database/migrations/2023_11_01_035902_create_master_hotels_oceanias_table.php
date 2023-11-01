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
        Schema::create('master_hotels_oceanias', function (Blueprint $table) {
            $table->id('id');
            $table->string('code');
            $table->string('hotel');
            $table->longText('facilities');
            $table->string('S2C');
            $table->string('ranking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_hotels_oceanias');
    }
};

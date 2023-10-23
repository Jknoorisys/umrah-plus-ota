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
        Schema::create('markups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('service', ['hotel', 'flight', 'transfer', 'activity', 'umrah', 'ziyarat', 'visa'])->default('hotel');
            $table->string('markup');
            $table->enum('status', ['active', 'inactive']);
            $table->softDeletes();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markups');
    }
};
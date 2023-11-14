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
        Schema::create('ziyarat_enquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ziyarat_package');
            $table->string('name');
            $table->string('country');
            $table->string('email');
            $table->integer('mobile');
            $table->integer('travellers');
            $table->integer('price');
            $table->date('date');
            $table->enum('status', ['pending', 'inprogress', 'booked', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ziyarat_enquiries');
    }
};

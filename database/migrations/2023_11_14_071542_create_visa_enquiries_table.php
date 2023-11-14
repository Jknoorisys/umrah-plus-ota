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
        Schema::create('visa_enquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('visa_type_id');
            $table->string('user_id');
            $table->string('email');
            $table->integer('mobile');
            $table->integer('travellers');
            $table->integer('price');
            $table->enum('status', ['pending', 'inprogress', 'approved', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_enquiries');
    }
};

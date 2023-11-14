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
        Schema::create('visa_packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('country');
            $table->string('processing_time');
            $table->longText('process');
            $table->longText('documents');
            $table->text('embassy');
            $table->enum('is_featured', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_packages');
    }
};

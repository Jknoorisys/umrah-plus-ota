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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->integer('otp');
            $table->string('country_code');
            $table->string('phone')->unique();
            $table->string('photo');
            $table->string('password');
            $table->enum('is_social', [0, 1])->default(0);
            $table->string('social_id');
            $table->enum('Social_type', ['facebook', 'google','simple'])->default('simple');
            $table->text('JWT_token');
            $table->enum('is_verified', ['no', 'yes'])->default('no');
            $table->enum('is_mobile_verified', ['no', 'yes'])->default('no');
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
        Schema::dropIfExists('users');
    }
};

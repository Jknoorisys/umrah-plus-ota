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
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('phone')->unique();
            $table->text('photo');
            $table->enum('type', ['admin', 'super_admin']);
            $table->enum('status', ['active', 'inactive']);
            $table->text('JWT_token');
            $table->string('password');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

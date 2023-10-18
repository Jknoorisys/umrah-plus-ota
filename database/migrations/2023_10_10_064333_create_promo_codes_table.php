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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('service', ['hotel', 'flight', 'transfer', 'activity', 'cruise', 'umrah', 'ziyarat', 'visa'])->default('hotel');
            $table->string('code')->unique();
            $table->enum('type', ['flat', 'percentage'])->default('percentage');
            $table->integer('max_usage_per_user')->default(1);
            $table->date('start_date');
            $table->date('expire_date');
            $table->float('discount');
            $table->float('max_discount');
            $table->float('min_purchase');
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
        Schema::dropIfExists('promo_codes');
    }
};

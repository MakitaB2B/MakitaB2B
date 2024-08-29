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
        Schema::create('dealer_cancelled_orders', function (Blueprint $table) {
            $table->id();
            $table->string('dealer_cancel_order_slug',50)->unique();
            $table->string('dealer_code');
            // $table->foreign('dealer_code')->references('Customer')->on('dealer_masters')->onDelete('cascade');
            $table->string('promo_code')->index();
            $table->foreign('promo_code')->references('promo_code')->on('promotions')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_cancelled_orders');
    }
};

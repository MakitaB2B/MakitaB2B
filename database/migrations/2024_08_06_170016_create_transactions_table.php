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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_slug',50)->unique();
            $table->string('promo_code')->index();
            $table->foreign('promo_code')->references('promo_code')->on('promotions')->onDelete('cascade')->nullable();
            $table->string('rm_name');
            // $table->string('dealer_code')->index();
            // $table->foreign('dealer_code')->references('dealer_code')->on('dealers')->onDelete('cascade')->nullable();
            $table->string('dealer_code');
            $table->foreign('dealer_code')->references('dealer_code')->on('dealer_masters')->onDelete('cascade');
            $table->string('dealer_name');
            $table->enum('product_type',['Offer Product','FOC']);
            $table->string('model_no');
            $table->string('price')->nullable();
            $table->integer('qty');
            $table->string('order_id')->index();
            $table->string('ordered_by');
            $table->string('status');
            $table->string('modified_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

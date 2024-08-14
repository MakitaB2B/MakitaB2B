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
        Schema::create('item_prices', function (Blueprint $table) {
            $table->id();
            $table->string('Item')->index();
            $table->string('Item Description');
            // $table->foreign('')->references('promo_code')->on('promotions')->onDelete('cascade')->nullable();
            $table->string('Product Code');
            $table->string('Category')->nullable(); //->index();
            // $table->foreign('dealer_code')->references('dealer_code')->on('dealers')->onDelete('cascade')->nullable();
            $table->string('U/M')->nullable();
            // $table->enum('product_type',['Offer Product','FOC']);
            $table->string('DLP')->nullable();
            $table->string('LP'); //->nullable();
            $table->string('MRP');
            $table->string('BEST');//->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_prices');
    }
};

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
        Schema::create('promotions', function (Blueprint $table) {
            
            $table->id();
            $table->string('promotion_slug',50)->unique();
            $table->string('promo_code')->index();
            $table->date('from_date');
            $table->date('to_date');
            $table->enum('product_type',['Offer Product','FOC']);
            $table->string('model_no');
            $table->string('model_desc')->nullable();
            $table->enum('price_type',['DLP','Best Price','Special price']);
            $table->integer('qty');
            $table->string('price')->nullable();
            $table->timestamps();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

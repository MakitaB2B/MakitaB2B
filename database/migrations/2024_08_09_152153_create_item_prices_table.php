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
        Schema::table('item_prices', function (Blueprint $table) {
            // $table->id();
            // $table->string('Item')->index();
            // $table->string('Item Description');
         
            // $table->string('Product Code');
            // $table->string('Category')->nullable(); 
            // $table->string('U/M')->nullable();
            // $table->string('DLP')->nullable();
            // $table->string('LP');
            // $table->string('MRP');
            // $table->string('BEST');
            // $table->timestamps();


            if (!Schema::hasColumn('item_prices', 'Effective Date')) {
                $table->string('Effective Date')->after('Item Description')->nullable();
                }


            // $table->foreign('')->references('promo_code')->on('promotions')->onDelete('cascade')->nullable();
            // $table->foreign('dealer_code')->references('dealer_code')->on('dealers')->onDelete('cascade')->nullable();
            // $table->enum('product_type',['Offer Product','FOC']);
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

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
        Schema::create('billed_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('billed_transaction_slug',50)->unique();
            $table->string('Day');
            $table->string('Invoice');
            $table->longText('Name');
            $table->string('Planner Code',9);
            $table->string('Invoice Date');
            $table->string('Customer');
            $table->string('Site');
            $table->string('Salesperson');
            $table->string('order_id');
            $table->string('promo_code');
            $table->string('Total Price');
            $table->string('Order');
            $table->string('Item');
            $table->string('Description');
            $table->tinyInteger('Qty Invoiced');
            $table->string('Price');
            $table->string('EXTENDED PRICE');
            $table->string('Whs');
            $table->string('Location');
            $table->string('Region');
            $table->string('Place');
            $table->string('State');
            $table->string('Product Code');
            $table->string('Product');
            $table->string('Family Code');
            $table->string('Power Code');
            $table->string('Area');
            $table->string('Group');
            $table->string('XGT-Tools');
            $table->string('DC Tools');
            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at')->default(date('Y-m-d H:i:s'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billed_transactions');
    }
};

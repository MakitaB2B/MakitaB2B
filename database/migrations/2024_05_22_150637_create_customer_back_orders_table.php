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
        Schema::create('customer_back_orders', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse',15);
            $table->string('region_place',25);
            $table->string('region_state',20);
            $table->string('order',30);
            $table->string('order_date',15);
            $table->string('po_details',60)->index();
            $table->string('customer_code',25)->index();
            $table->string('name',150)->index();
            $table->string('item',30)->index();
            $table->string('item_description')->index();
            $table->string('catagories',10)->index();
            $table->string('qty_ordered',10);
            $table->string('shipped',10);
            $table->string('reserved',10);
            $table->string('back_orders',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_back_orders');
    }
};

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
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->id();
            $table->string('date',20)->index();
            $table->string('fy',15)->comment('Financial Year');
            $table->string('year',10)->index();
            $table->string('month',10)->index();
            $table->string('q',10)->index()->comment('quarter');
            $table->string('category',20)->index()->comment('Tools Category');
            $table->string('model_no_part_no',50)->index();
            $table->string('description')->index();
            $table->string('customer_no',50)->index();
            $table->string('customer_name')->index();
            $table->string('wh_branch',50)->index();
            $table->string('region',20)->index();
            $table->string('state',25)->index();
            $table->string('sales_qty',10);
            $table->string('unit_cost',10)->index();
            $table->string('sales_value',50)->index();
            $table->string('invoice_no',50)->index();
            $table->string('category_type',15)->index();
            $table->string('customer_order_number',25)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_sales');
    }
};

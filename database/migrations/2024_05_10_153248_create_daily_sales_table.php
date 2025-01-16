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
        Schema::table('daily_sales', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_sales', 'id')) {
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
            $table->string('region',20)->nullable()->index()->after('wh_branch');
            $table->string('state',25)->nullable()->index()->after('region');
            $table->string('sales_qty',10);
            $table->string('unit_cost',10)->index();
            $table->string('sales_value',50)->index();
            $table->string('invoice_no',50)->index();
            $table->string('category_type',15)->index();
            $table->string('customer_order_number',25)->index();
            $table->timestamps();
            }

            $table->string('customer_name')->nullable()->after('customer_no')->change();
            $table->string('wh_branch',50)->nullable()->after('customer_name')->change();
            $table->string('category_type',15)->nullable()->after('invoice_no')->change();
           
            if (!Schema::hasColumn('daily_sales', 'sales_person')) {
                $table->string('sales_person',10)->nullable()->after('customer_order_number');
            }

            if (!Schema::hasColumn('daily_sales', 'sales_person_name')) {
                $table->string('sales_person_name',30)->nullable()->after('sales_person');
            }

            if (!Schema::hasColumn('daily_sales', 'sub_category')) {
                $table->string('sub_category',30)->nullable()->after('category');
            }

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

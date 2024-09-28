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
        Schema::table('billed_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('billed_transactions', 'id')) {
            $table->id();
            $table->string('billed_transaction_slug',50)->unique();
            $table->string('Day')->nullable();
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
            }
            if (!Schema::hasColumn('billed_transactions', 'Extended Price')) {
            $table->string('Extended Price')->after('Price')->nullable();
            }
            if (!Schema::hasColumn('billed_transactions', 'Whs')) {
            $table->string('Whs')->nullable();
            }
            if (!Schema::hasColumn('billed_transactions', 'id')) {
            $table->string('Location')->nullable();
            $table->string('Region')->nullable();
            $table->string('Place')->nullable();
            $table->string('State')->nullable();
            $table->string('Product Code')->nullable();
            $table->string('Product')->nullable();
            $table->string('Family Code')->nullable();
            $table->string('Power Code')->nullable();
            $table->string('Area')->nullable();
            $table->string('Group')->nullable();
            $table->string('XGT-Tools')->nullable();
            $table->string('DC Tools')->nullable();
            }
            if (!Schema::hasColumn('billed_transactions', 'create_date')) {
            $table->string('create_date')->after('DC Tools');
            }
            if (!Schema::hasColumn('billed_transactions', 'id')) {
            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at')->default(date('Y-m-d H:i:s'));
            }
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

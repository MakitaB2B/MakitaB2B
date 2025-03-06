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
        Schema::table('ltc_food_claims', function (Blueprint $table) {
            // $table->id();
            // $table->string('ltc_food_claims_slug', 50)->unique();
            // $table->string('employee_slug',50);
            // $table->string('ltc_date');
            // $table->enum('ltc_day',['On Leave','Holiday','Working Day','Working on Holiday'])->comment('W->Working Day, H->Holiday, O->On Leave, WH->Working on Holiday');
            // $table->string('in_time')->default(0);
            // $table->string('out_time')->default(0);
            // $table->unsignedDecimal('food_exp', 21, 4);
            // $table->string('food_exp_bill')->nullable();
            // $table->timestamps();
            // $table->string('ltc_claim_id')->after('ltc_date')->index();
            // $table->string('claim_date')->after('ltc_claim_id');
            // $table->string('ltc_claim_applications_slug',50)->nullable()->change();
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 - Not Submitted, 1 - Not Review, 2 - Approved By Manager, 3 - Rejected By Manager, 4 - Amount Paid, 5 - Approved By HR, 6 - Rejected By HR, 7 - Case clear By Accounts, 8 - Case closed,9 - Rejected By Account')->change()
                ->after('food_exp_bill');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_food_claims');
    }
};

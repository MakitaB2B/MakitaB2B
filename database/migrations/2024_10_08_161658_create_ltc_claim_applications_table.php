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
        Schema::table('ltc_claim_applications', function (Blueprint $table) {
            // $table->id();
            // $table->string('ltc_claim_applications_slug',50);
            // $table->string('ltc_claim_id')->index();
            // $table->string('employee_slug',50);
            // $table->tinyInteger('ltc_month')->unsigned()->check('ltc_month >= 1 AND ltc_month <= 12');
            // $table->smallInteger('ltc_year');
            // $table->unsignedDecimal('total_claim_amount', 21, 4)->after('ltc_year')->change();
            // $table->unsignedDecimal('payed_amount', 21, 4)->default(0)->after('total_claim_amount')->change();
            // $table->string('manager_slug',50);
            // $table->string('manager_approved_by')->nullable();
            // $table->string('hr_approved_by')->nullable();
            // $table->string('accountdep_approved_by')->nullable()->after('hr_approved_by')->change();
            // $table->string('payment_by')->nullable();
            // $table->tinyInteger('status')->default(0)->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 -  Case closed , 8 - Rejected By Account')->change();
            // $table->string('operated_by')->nullable();
            // $table->timestamps();
          



            // $table->enum('status', [0, 1, 2,3 ,4 , 5, 6,7,8,9])->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_claim_applications');
    }
};
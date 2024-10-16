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
            $table->unsignedDecimal('payed_amount', 21, 4)->default(0)->after('total_claim_amount')->change();
            // $table->string('manager_slug',50);
            // $table->string('manager_approved_by')->nullable();
            // $table->string('hr_approved_by')->nullable();
            // $table->string('accountdep_approved_by')->nullable()->after('hr_approved_by')->change();
            // $table->string('payment_by')->nullable();
            // $table->enum('status', [0, 1, 2,3 ,4 , 5, 6,7,8,9])->default(0); 
            // $table->string('operated_by')->nullable();
            // $table->timestamps();
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

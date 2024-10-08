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
        Schema::create('ltc_claims', function (Blueprint $table) {
            $table->id();
            $table->string('ltc_claim_slug',50)->unique();
            $table->string('ltc_claim_applications_slug',50);
            $table->string('employee_slug',50);
            $table->string('ltc_claim_id')->index();
            $table->date('date');
            $table->string('mode_of_transport',50);
            $table->unsignedDecimal('opening_meter', 21, 4)->change();
            $table->unsignedDecimal('closing_meter', 21, 4)->change();
            $table->unsignedDecimal('total_km', 21, 4)->change();
            $table->string('place_visited',80);
            $table->unsignedDecimal('claim_amount', 21, 4)->change();
            $table->unsignedDecimal('lunch_exp', 21, 4)->change();
            $table->unsignedDecimal('fuel_exp', 21, 4)->change();
            $table->unsignedDecimal('toll_charge', 21, 4)->change();
            $table->enum('status', [0, 1, 2])->default(0);
            $table->timestamps();

            // $table->tinyInteger('ltc_month')->unsigned()->check('ltc_month >= 1 AND ltc_month <= 12');
            // $table->smallInteger('ltc_year')->change();
            // $table->string('manager_slug',50);
            // $table->string('manager_approved_by')->nullable();
            // $table->string('hr_approved_by')->nullable();
            // $table->string('payment_by')->nullable();
            //$table->enum('status', [0, 1, 2])->default(0); // 0 - not reviewed, 1 - paid , 2 - rejected
            // $table->string('operated_by')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_claims');
    }
};

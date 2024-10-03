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
            $table->string('employee_slug',50)->unique();
            $table->string('ltc_claim_id')->index();
            $table->tinyInteger('ltc_month');
            $table->tinyInteger('ltc_year');
            $table->date('date');
            $table->string('mode_of_transport',50);
            $table->unsignedDecimal('opening_meter', $precision = 9, $scale = 4);
            $table->unsignedDecimal('closing_meter', $precision = 9, $scale = 4);
            $table->unsignedDecimal('total_km', $precision = 9, $scale = 4);
            $table->string('place_visited',80);
            $table->unsignedDecimal('claim_amount', $precision = 9, $scale = 4);
            $table->unsignedDecimal('lunch_exp', $precision = 9, $scale = 4);
            $table->unsignedDecimal('fuel_exp', $precision = 9, $scale = 4);
            $table->unsignedDecimal('toll_charge', $precision = 9, $scale = 4);
            $table->string('manager_slug',50)->unique();
            $table->string('manager_approved_by')->nullable();
            $table->string('hr_approved_by')->nullable();
            $table->string('payment_by')->nullable();
            $table->enum('status', [0, 1, 2])->default(0); // 0 - not reviewed, 1 - paid , 2 - rejected
            $table->string('operated_by');
            $table->timestamps();
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

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
        Schema::create('ltc_miscellaneous_exps', function (Blueprint $table) {
            $table->id();
            $table->string('ltc_miscellaneous_slug',50)->unique();
            $table->string('ltc_claim_applications_slug',50);
            $table->string('employee_slug',50);
            $table->string('ltc_claim_id')->index();
            $table->unsignedDecimal('courier_bill', 21, 4);
            $table->unsignedDecimal('xerox_stationary', 21, 4);
            $table->unsignedDecimal('office_expense', 21, 4);
            $table->unsignedDecimal('monthly_mobile_bills', 21, 4);
            $table->longText('remarks');
            $table->enum('status', [0, 1, 2])->default(0); // 0 - not reviewed, 1 - paid , 2 - rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_miscellaneous_exps');
    }
};

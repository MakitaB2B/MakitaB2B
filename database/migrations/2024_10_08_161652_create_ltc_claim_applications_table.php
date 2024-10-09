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
        Schema::create('ltc_claim_applications', function (Blueprint $table) {
            $table->id();
            $table->string('ltc_claim_applications_slug',50);
            $table->string('ltc_claim_id')->index();
            $table->string('employee_slug',50);
            $table->tinyInteger('ltc_month')->unsigned()->check('ltc_month >= 1 AND ltc_month <= 12');
            $table->smallInteger('ltc_year');
            $table->string('manager_slug',50);
            $table->string('manager_approved_by')->nullable();
            $table->string('hr_approved_by')->nullable();
            $table->string('payment_by')->nullable();
            $table->enum('status', [0, 1, 2])->default(0); // 0 - not reviewed, 1 - paid , 2 - rejected
            $table->string('operated_by')->nullable()->change();
            $table->timestamps();
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

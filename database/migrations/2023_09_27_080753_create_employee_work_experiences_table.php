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
        Schema::create('employee_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('emloyee_slug');
            $table->string('company_name')->index();
            $table->string('appointment_letter');
            $table->string('relieving_letter');
            $table->string('payslip_last_month');
            $table->string('payslip_2nd_last_month');
            $table->string('payslip_3rd_last_month');
            $table->string('ewe_slug')->unique();
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_work_experiences');
    }
};

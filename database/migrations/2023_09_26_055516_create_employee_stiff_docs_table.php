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
        Schema::create('employee_stiff_docs', function (Blueprint $table) {
            $table->id();
            $table->string('emp_slug')->unique();
            $table->string('pf_uan_number')->nullable()->index();
            $table->string('aadhar_card');
            $table->string('pan_card');
            $table->string('driving_licence')->nullable();
            $table->string('passport')->nullable();
            $table->string('sslc_marks_card');
            $table->string('puc_marks_card');
            $table->string('degree_marks_card');
            $table->string('higher_degree_marks_card')->nullable();
            $table->string('esd_slug')->unique();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_stiff_docs');
    }
};

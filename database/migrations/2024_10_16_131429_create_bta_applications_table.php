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
        Schema::create('bta_applications', function (Blueprint $table) {
            $table->id();
            $table->string('emp_slug',30);
            $table->string('bta_application_id',30)->unique();
            $table->timestamp('starting_date_time');
            $table->timestamp('ending_date_time');
            $table->string('number_of_days',20);
            $table->string('place_of_visit',100);
            $table->string('purpose_of_visit',150);
            $table->string('total_expenses',25);
            $table->tinyInteger('status')->comment('0-> Not Review, 1->Approved By Manager, 2->Rejected By Manager, 3-> Advance Paid, 4-> Approved By HR, 5-> Rejected By HR, 6-> Case clear By Accounts, 7-> Case closed ');
            $table->string('advance_amount')->nullable();
            $table->string('balance_amount')->nullable();
            $table->string('is_group_bt')->nullable()->comment('0->No, 1->Yes');
            $table->string('manager_slug',30);
            $table->string('manager_approved_by',30)->nullable();
            $table->string('advanced_paid_by',30)->nullable();
            $table->string('hr_approved_by',30)->nullable();
            $table->string('accountdep_approved_by',30)->nullable();
            $table->string('bta_slug',25);
            $table->string('created_by',25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bta_applications');
    }
};

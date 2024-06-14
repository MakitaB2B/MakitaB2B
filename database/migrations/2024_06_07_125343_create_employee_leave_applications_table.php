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
        Schema::create('employee_leave_applications', function (Blueprint $table) {
            $table->id();
            $table->string('employee_slug');
            $table->enum('leave_type',['Earned Leave','Sick Leave','Casual Leave','Loss of Pay']);
            $table->text('comments');
            $table->date('from_date');
            $table->date('to_date');
            $table->enum('approval_status',['Approved','Rejected','Pending'])->default('Pending');
            $table->string('responsedby_empslug')->nullable();
            $table->timestamp('response_datetime')->nullable();
            $table->string('emp_leave_apply_slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leave_applications');
    }
};

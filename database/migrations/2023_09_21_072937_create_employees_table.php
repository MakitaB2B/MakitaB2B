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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_no')->nullable()->unique()->index();
            $table->string('full_name')->index();
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('dob');
            $table->tinyInteger('age');
            $table->enum('sex',['male','female']);
            $table->enum('marital_status',['married','unmarried']);
            $table->string('photo');
            $table->string('phone_number',25)->index();
            $table->string('alt_phone_number',25)->index()->nullable();
            $table->string('personal_email')->index()->nullable();
            $table->string('official_email')->index()->nullable();
            $table->text('current_address');
            $table->text('permanent_address');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade')->nullable();
            $table->date('joining_date');
            $table->unsignedBigInteger('posting_state');
            $table->foreign('posting_state')->references('id')->on('states')->onDelete('cascade')->nullable()->unsigned();
            $table->unsignedBigInteger('posting_city');
            $table->foreign('posting_city')->references('id')->on('cities')->onDelete('cascade')->nullable()->unsigned();
            $table->string('employee_slug');
            $table->tinyInteger('status')->default(1)->nullable()->unsigned();
            $table->integer('crated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

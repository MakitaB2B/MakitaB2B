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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_slug')->unique();
            $table->string('name',100)->nullable()->index();
            $table->string('phone',25)->index();
            $table->string('email',150)->nullable()->index();
            $table->bigInteger('state')->unsigned()->nullable();
            $table->string('city',150)->nullable();
            $table->text('address')->nullable();
            $table->enum('gender',['Male','Female','Other'])->nullable();;
            $table->integer('age')->nullable()->unsigned();
            $table->string('industry',100)->nullable();
            $table->string('job_title',100)->nullable();
            $table->bigInteger('company_size')->nullable()->unsigned();
            $table->tinyInteger('profile_stage')->nullable()->unsigned();
            $table->tinyInteger('status')->nullable()->unsigned();
            $table->string('otp')->nullable();
            $table->timestamp('otp_created_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

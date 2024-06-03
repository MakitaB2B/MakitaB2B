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
        Schema::create('tools_services', function (Blueprint $table) {
            $table->id();
            $table->string('cx_slug',50)->comment('Customer Slug');
            $table->string('trn',20)->index()->unique();
            $table->timestamp('sr_date');
            $table->text('tools_issue');
            $table->string('service_center',30);
            $table->string('repairer',30)->nullable();
            $table->string('delear_customer_name',70)->index()->nullable();
            $table->string('contact_number',20)->index()->nullable();
            $table->string('model',25)->nullable();
            $table->string('tools_sl_no',25)->nullable();
            $table->timestamp('receive_date_time')->nullable();
            $table->timestamp('estimation_date_time')->nullable();
            $table->integer('duration_a_b')->nullable()->comment('IN Minutes');
            $table->string('cost_estimation',10)->nullable();
            $table->timestamp('est_date_confirm_cx')->nullable();
            $table->string('costestimation_file')->nullable();
            $table->longText('reason_if_rejected')->nullable();
            $table->timestamp('repair_complete_date_time')->nullable();
            $table->integer('duration_c_d')->nullable()->comment('IN Minutes');
            $table->timestamp('handover_date_time')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->string('total_hour_for_repair',70)->nullable()->comment('IN Minutes');
            $table->text('repair_parts_details')->nullable();
            $table->text('reason_for_over_48h')->nullable();
            $table->text('part_number_reason_for_delay')->nullable();
            $table->text('sr_closing_reason')->nullable();
            $table->string('sr_slug',20)->unique();
            $table->string('last_updatedByemp',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools_services');
    }
};

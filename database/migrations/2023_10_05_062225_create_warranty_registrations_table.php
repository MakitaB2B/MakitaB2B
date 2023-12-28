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
        Schema::create('warranty_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_slug');
            $table->enum('mode_of_purchase',['online','offline']);
            $table->string('purchase_from');
            $table->string('place_of_purchase');
            $table->date('date_of_purchase');
            $table->date('warranty_expiry_date');
            $table->string('model_number');
            $table->string('invoice_number');
            $table->string('machine_serial_number');
            $table->string('invoice_copy')->nullable();
            $table->string('machine_slno_photo');
            $table->text('comment')->nullable();
            $table->string('warranty_slug')->unique();
            $table->enum('application_status',['in-review','accepted','rejected'])->nullable();
            $table->tinyInteger('warranty_status')->default(0)->nullable()->comment('1->In Warranty,0->Not in warranty');
            $table->string('latest_warranty_application_slug')->nullable();
            $table->string('application_status_reviewed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_registrations');
    }
};

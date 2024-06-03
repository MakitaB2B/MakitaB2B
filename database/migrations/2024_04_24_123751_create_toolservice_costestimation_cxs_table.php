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
        Schema::create('toolservice_costestimation_cxs', function (Blueprint $table) {
            $table->id();
            $table->string('service_slug',30);
            $table->string('trn',30)->index();
            $table->string('costestimation_file');
            $table->enum('status',['accept','reject'])->nullable();
            $table->longText('reason_if_rejected')->nullable();
            $table->string('costestimation_slug',30);
            $table->string('lastupdated_byemp',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toolservice_costestimation_cxs');
    }
};

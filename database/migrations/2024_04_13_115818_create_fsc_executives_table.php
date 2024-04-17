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
        Schema::create('fsc_executives', function (Blueprint $table) {
            $table->id();
            $table->string('fsc_slug',20);
            $table->foreign('fsc_slug')->references('fsc_slug')->on('factory_service_centers')->onDelete('cascade')->nullable();
            $table->string('employee_slug',20);
            $table->string('created_by',30);
            $table->string('fsc_excecutive_slug',20)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsc_executives');
    }
};

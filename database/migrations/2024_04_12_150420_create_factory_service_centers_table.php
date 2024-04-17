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
        Schema::create('factory_service_centers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->nullable();
            $table->string('center_name',100)->index()->unique();
            $table->string('phone',20)->index()->nullable();
            $table->string('email',50)->index()->nullable();
            $table->text('center_address')->nullable();
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->string('created_by',30);
            $table->string('fsc_slug',20)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_service_centers');
    }
};

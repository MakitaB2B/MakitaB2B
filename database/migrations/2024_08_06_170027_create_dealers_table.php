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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('dealer_slug',50)->unique();
            $table->string('customer');
            $table->string('dealer_code');
            $table->string('dealer_name');
            $table->string('state_code');
            $table->integer('zip_code');
            $table->string('cardinal_direction');
            $table->string('type');
            $table->string('is_authorized');
            $table->string('is_black_listed');
            $table->string('reason_to_blacklist');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};

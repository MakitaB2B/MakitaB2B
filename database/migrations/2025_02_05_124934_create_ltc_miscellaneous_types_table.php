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
        Schema::create('ltc_miscellaneous_types', function (Blueprint $table) {
            $table->id();
            $table->string('ltc_miscellaneous_types_slug',50)->unique();
            $table->string('ltc_misc_type',100);
            $table->string('status',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_miscellaneous_types');
    }
};

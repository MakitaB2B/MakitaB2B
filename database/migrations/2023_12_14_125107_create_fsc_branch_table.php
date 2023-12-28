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
        Schema::create('fsc_branch', function (Blueprint $table) {
            $table->id();
            $table->text('address');
            $table->string('pin',10);
            $table->string('place_short_code',10);
            $table->integer('city');
            $table->integer('state');
            $table->string('phone1',20);
            $table->string('phone2',20);
            $table->string('phone3',20);
            $table->string('fscb_slug',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsc_branch');
    }
};

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
        Schema::create('reserved_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('itemdescription');
            $table->string('category');
            $table->string('reftype');
            $table->string('order');
            $table->string('customer');
            $table->string('customername');
            $table->string('reserved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserved_stocks');
    }
};

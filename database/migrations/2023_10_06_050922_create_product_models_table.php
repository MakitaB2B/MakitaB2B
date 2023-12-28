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
        Schema::create('product_models', function (Blueprint $table) {
            $table->id();
            $table->string('model_number')->comments('Item Code');
            $table->string('description');
            $table->integer('warranty_period')->comments('Warranty in months');
            $table->string('category');
            $table->string('product_code',20);
            $table->integer('status')->comments('1-> Active, 0->De-Active');
            $table->string('model_slug',50);
            $table->string('created_by',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_models');
    }
};

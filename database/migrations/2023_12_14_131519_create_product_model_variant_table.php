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
        Schema::create('product_model_variant', function (Blueprint $table) {
            $table->id();
            $table->string('item',100)->index();
            $table->string('description')->index();
            $table->string('category',10)->index();
            $table->string('total_stock',20)->index();
            $table->integer('updated_by');
            $table->string('pmv_slug',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_model_variant');
    }
};

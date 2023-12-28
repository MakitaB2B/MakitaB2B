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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('products_categories')->onDelete('cascade');
            $table->string('model',50)->nullable()->index();
            $table->string('name')->unique()->index();
            $table->string('product_slug')->unique();
            $table->unsignedDecimal('product_price', $precision = 9, $scale = 4)->index();
            $table->string('primary_image')->nullable();
            $table->text('short_description')->nullable()->index();
            $table->longText('long_description')->nullable();
            $table->longText('technical_info')->nullable();
            $table->longText('general_info')->nullable();
            $table->longText('support')->nullable();
            $table->text('video_link')->nullable();
            $table->longText('keywords')->nullable()->index();
            $table->integer('warranty')->nullable()->index();
            $table->tinyInteger('status')->default(0)->nullable()->unsigned()->index();
            $table->tinyInteger('tax_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

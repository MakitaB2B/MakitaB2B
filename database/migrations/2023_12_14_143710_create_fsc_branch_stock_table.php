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
        Schema::create('fsc_branch_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_variant_id');
            $table->foreign('model_variant_id')->references('id')->on('product_model_variant')->onDelete('cascade');
            $table->unsignedBigInteger('fsc_branch_id');
            $table->foreign('fsc_branch_id')->references('id')->on('fsc_branch')->onDelete('cascade');
            $table->string('main',15)->nullable()->index();
            $table->string('demo_in',15)->nullable()->index();
            $table->string('demo_out',15)->nullable()->index();
            $table->string('service_room',15)->nullable()->index();
            $table->string('show_room',15)->nullable()->index();
            $table->string('fscbs_slug',30)->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsc_branch_stock');
    }
};

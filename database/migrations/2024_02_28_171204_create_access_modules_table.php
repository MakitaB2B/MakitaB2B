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
        Schema::create('access_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique();
            $table->string('module_slug');
            $table->tinyInteger('status')->default(1)->nullable()->unsigned();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_modules');
    }
};

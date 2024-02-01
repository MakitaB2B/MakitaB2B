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
        Schema::create('replaced_parts', function (Blueprint $table) {
            $table->id();
            $table->string('oldno')->index();
            $table->string('replace1')->index();
            $table->string('replace2')->index();
            $table->string('replaced3')->index();
            $table->string('descriptionsystem');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replaced_parts');
    }
};

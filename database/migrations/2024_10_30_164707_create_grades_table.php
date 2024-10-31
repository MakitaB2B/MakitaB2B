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
        Schema::table('grades', function (Blueprint $table) {
            // $table->id();
            // $table->string('grades_slug',50)->unique()->nullable()->change();
            // $table->string('grades_slug', 50)->unique()->nullable()->change();
            // $table->string('grade',3);
            $table->string('department',25)->change();
            // $table->string('designation',50);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};

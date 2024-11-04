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
        Schema::table('dearness_allowances', function (Blueprint $table) {
            // $table->id();
            $table->string('dearness_allowances_slug',50)->unique()->nullable()->change();
            // $table->string('grade', 3)->index();
            // $table->decimal('amount', 10, 2);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dearness_allowances');
    }
};


//M1 - 900 
//M2 - 650  
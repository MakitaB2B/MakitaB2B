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
        Schema::table('mode_of_travel', function (Blueprint $table) {
            // $table->id();
            // $table->string('mode_of_travel_slug',50)->unique()->nullable()->change();
            // $table->string('grade',3);
            // $table->string('travel_mode',70);
            $table->string('class')->after('travel_mode')->change();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mode_of_travel');
    }
};


// M1 - AC2
// M1 - AC3
// M1 - AC Chair Car
// M2 - AC2  
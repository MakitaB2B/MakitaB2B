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
        Schema::table('local_conveyances', function (Blueprint $table) {
            // $table->id();
            $table->string('local_conveyance_slug',50)->unique()->nullable()->change();
            // $table->string('grade', 3); 
            // $table->enum('conveyance_type', ['Company Vehicle', 'Own Vehicle']); 
            // $table->enum('conveyance', ['Taxi', 'Auto', '2-Wheeler', '4-Wheeler']);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_conveyances');
    }
};


// M1 - AC2
// M1 - AC3
// M1 - AC Chair Car
// M2 - AC2  
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
        Schema::create('lodging_boardings', function (Blueprint $table) {
            $table->id();
            $table->string('lodging_boardings_slug',50)->unique();
            $table->string('grade', 3);
            $table->enum('city_category', ['A', 'B', 'C', 'D']); 
            $table->string('pay_type', 10); 
            $table->decimal('pay_amount', 10, 2)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lodging_boardings');
    }
};


//grade	city_category	pay_type	pay_amount
// M1    - A            - Actual     - null
// M1    - B            - Actual     - null
// M1    - C            - Actual     - null
// M1    - D            - Actual     - null
// M2    - A            - Fixed      - 4500
// M2    - B            - Fixed      - 3000
// M2    - C            - Fixed      - 3000
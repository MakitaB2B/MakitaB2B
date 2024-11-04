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
        Schema::table('enroute_expenses', function (Blueprint $table) {
            // $table->id();
            $table->string('enroute_expenses_slug',50)->unique()->nullable()->change();
            // $table->string('grade', 3)->index();
            // $table->string('enroute_type', 30)->index();
            // $table->enum('bill_type', ['WB', 'WOB']);
            // $table->decimal('amount', 10, 2);
             
           
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enroute_expenses');
    }
};

 // $table->time('from_time'); 
 // $table->time('to_time'); 

//M1 - Breakfast -  WB  - 100 - 6:00 - 12:00 
//M1 - Breakfast -  WOB - 100 - 6:00 - 12:00 
//M1 - Lunch     -  WB  - 150 - 6:00 - 14:00 
//M1 - Lunch     -  WOB - 100 - 6:00 - 14:00 
//M1 - Dinner    -  WB  - 250 - 6:00 - 21:00 
//M1 - Dinner    -  WOB - 150 - 6:00 - 21:00 
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
        Schema::create('demo_vans', function (Blueprint $table) {
            $table->id(); 
            $table->string('demo_vans_slug', 50)->unique()->nullable();
            $table->string('particulars', 100);
            $table->integer('model_no'); 
            $table->string('used_by', 100);
            $table->string('purpose', 100);
            $table->string('location', 100);
            $table->string('state', 100);
            $table->string('date_of_purchase', 100); 
            $table->string('parking', 100);
            $table->string('vehicles_reg_no', 100);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_vans');
    }
};

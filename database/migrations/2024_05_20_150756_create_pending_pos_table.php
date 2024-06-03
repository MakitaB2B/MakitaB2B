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
        Schema::create('pending_pos', function (Blueprint $table) {
            $table->id();
            $table->string('vendorpo',30)->index();
            $table->string('vendor',50)->index();
            $table->string('name',100)->index();
            $table->string('po',20)->index();
            $table->string('line',15);
            $table->string('item',15)->index();
            $table->string('itemdescription')->index();
            $table->string('cat',10)->index();
            $table->string('ordered',20)->index();
            $table->string('poorderdate',30)->index();
            $table->string('duedate',30)->index();
            $table->string('month',15)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_pos');
    }
};

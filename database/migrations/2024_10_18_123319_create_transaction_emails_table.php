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
        Schema::create('transaction_emails', function (Blueprint $table) {
            $table->id();
            $table->string('rm_slug',50);
            $table->string('region',25);
            $table->string('sales_slug',50);
            $table->string('mail_id',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_emails');
    }
};

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
        Schema::create('asset_audit_books', function (Blueprint $table) {
            $table->id();
            $table->enum('asset_type',['Laptop','Desktop','Mac']);
            $table->string('asset_tag',30);
            $table->enum('make',['Lenovo','Fujitsu','Dynabook','Toshiba','HP','iMac']);
            $table->string('model_number',50);
            $table->string('serial_number',30);
            $table->string('emp_slug',30);
            $table->string('asset_auditbk_slug',30);
            $table->string('created_by',30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_audit_books');
    }
};

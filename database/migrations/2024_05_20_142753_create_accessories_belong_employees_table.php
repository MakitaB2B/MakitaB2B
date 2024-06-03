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
        Schema::create('accessories_belong_employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_slug',30);
            $table->string('asset_auditbk_slug',30);
            $table->string('accesories_name',70);
            $table->string('created_by',30)->nullable();
            $table->string('accessoriesbe_slug',30);
            $table->string('asset_tag',30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories_belong_employees');
    }
};

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
        Schema::create('accessoriesimg_belong_employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_slug',30);
            $table->string('asset_auditbk_slug',30);
            $table->string('accessoriesbe_slug',30);
            $table->string('accessories_name',30)->nullable();
            $table->string('asset_photo1',30);
            $table->string('asset_photo2',30)->nullable();
            $table->string('asset_photo3',30)->nullable();
            $table->string('created_by',30)->nullable();
            $table->string('aibe_slug',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessoriesimg_belong_employees');
    }
};

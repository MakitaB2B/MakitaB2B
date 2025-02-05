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
        Schema::create('ltc_files', function (Blueprint $table) {
            $table->id()->change();
            $table->string('ltc_files_slug', 50)->unique();
            $table->string('ltc_claim_applications_slug',50)->nullable();
            $table->string('employee_slug',50);
            $table->string('type');
            $table->string('file_type');
            $table->string('file_path');
            $table->string('ltc_claim_id')->index();
            $table->string('claim_date');
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 - Case closed, 8 - Rejected By Account')
                ;
            $table->morphs('fileable');
            $table->timestamps();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_files');
    }
};

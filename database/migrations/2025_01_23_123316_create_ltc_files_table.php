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
        Schema::table('ltc_files', function (Blueprint $table) {
            // $table->id();
            // $table->string('ltc_files_slug', 50)->unique();
            // $table->string('ltc_claim_applications_slug',50)->nullable();
            // $table->string('employee_slug',50);
            // $table->string('type');
            // $table->string('file_type');
            // $table->string('file_path');
            // $table->string('ltc_claim_id')->index();
            // $table->string('claim_date');
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 - Not Submitted, 1 - Not Review, 2 - Approved By Manager, 3 - Rejected By Manager, 4 - Amount Paid, 5 - Approved By HR, 6 - Rejected By HR, 7 - Case clear By Accounts, 8 - Case closed,9 - Rejected By Account')->change()
                ;

            //----old    
            //$table->morphs('fileable');
            //$table->stringMorphs('fileable'); 
            //----old   
            //$table->string('fileable_id'); // Change from unsignedBigInteger to string
            //$table->string('fileable_type');
            //$table->timestamps();
       
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

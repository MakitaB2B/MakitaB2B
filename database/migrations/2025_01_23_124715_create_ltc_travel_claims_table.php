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
        Schema::table('ltc_travel_claims', function (Blueprint $table) {
            // $table->id();
            // $table->string('ltc_travel_claims_slug', 50)->unique();
            // $table->string('ltc_claim_applications_slug',50);
            // $table->string('employee_slug',50);
            // $table->enum('mode_of_transport',['Company','Private','Public']);
            // $table->enum('type_of_transport',['Train','Metro','Taxi','Auto','Demo Van','2-Wheeler','4-Wheeler','Bus','Car']);
            // $table->string('place_visited',80);
            // $table->unsignedDecimal('opening_meter', 21, 4);
            // $table->unsignedDecimal('closing_meter', 21, 4);
            // $table->unsignedDecimal('total_km', 21, 4);
            // $table->unsignedDecimal('toll_charge', 21, 4);
            // $table->unsignedDecimal('claim_amount', 21, 4);
            // $table->timestamps();
            //$table->enum('type_of_transport',['Train','Metro','Taxi','Auto','Demo Van','2-Wheeler','4-Wheeler','Bus','Car'])->change();

            
            $table->string('demo_van_no',50)->after('mode_of_transport')->nullable();
            $table->string('ltc_claim_id')->after('type_of_transport')->index();
            $table->string('claim_date')->after('ltc_claim_id');
            $table->string('ltc_claim_applications_slug',50)->nullable()->change();
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 - Case closed, 8 - Rejected By Account')
                ->after('claim_amount');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_travel_claims');
    }
};

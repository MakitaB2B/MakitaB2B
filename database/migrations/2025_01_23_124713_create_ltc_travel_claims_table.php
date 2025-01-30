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

            // if (!Schema::hasColumn('ltc_travel_claims', 'demo_van_no')) {
            //     $table->string('demo_van_no',50)->after('mode_of_transport')->nullable();
            // }

            $table->enum('type_of_transport',['Train','Metro','Taxi','Auto','Demo Van','2-Wheeler','4-Wheeler','Bus','Car'])->change();
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

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
        Schema::table('ltc_miscellaneous_exps', function (Blueprint $table) {
            // $table->id();
            // $table->string('ltc_miscellaneous_slug',50)->unique();
            // $table->string('ltc_claim_applications_slug',50);
            // $table->string('employee_slug',50);
            // $table->enum('misc_type',['Courier Bill','Xerox Stationary','Office Expense','Monthly Mobile Bills','Dealer Entertainment']);
            // $table->unsignedDecimal('claim_amount', 21, 4);
            // $table->tinyInteger('status')
            //     ->default(0)
            //     ->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 - Case closed, 8 - Rejected By Account')
            //     ->after('remarks')->change();
            // $table->timestamps();


           
            // $table->string('ltc_claim_applications_slug',50)->nullable()->change();
            // $table->string('ltc_claim_id')->after('claim_amount')->index();
            // $table->string('claim_date')->after('ltc_claim_id');
            
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0 - Not Submitted, 1 - Not Review, 2 - Approved By Manager, 3 - Rejected By Manager, 4 - Amount Paid, 5 - Approved By HR, 6 - Rejected By HR, 7 - Case clear By Accounts, 8 - Case closed,9 - Rejected By Account')
                ->after('claim_amount')->change();



            //$table->string('misc_type',300)->change();






            // $table->string('ltc_claim_id')->index();
            // $table->unsignedDecimal('courier_bill', 21, 4);
            // $table->unsignedDecimal('xerox_stationary', 21, 4);
            // $table->unsignedDecimal('office_expense', 21, 4);
            // $table->unsignedDecimal('monthly_mobile_bills', 21, 4);
            // $table->longText('remarks');
           // $table->enum('status', [0, 1, 2])->default(0); // 0 - not reviewed, 1 - paid , 2 - rejected
            // $table->timestamps();
            // $table->tinyInteger('status')->default(0)->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 -  Case closed , 8 - Rejected By Account')->change();

            // if (!Schema::hasColumn('ltc_miscellaneous_exps', 'status')) {

                // $table->tinyInteger('status')
                // ->default(0)
                // ->comment('0 - Not Review, 1 - Approved By Manager, 2 - Rejected By Manager, 3 - Amount Paid, 4 - Approved By HR, 5 - Rejected By HR, 6 - Case clear By Accounts, 7 - Case closed, 8 - Rejected By Account')
                // ->after('remarks')->change();
                // $table->string('Extended Price')->after('Price')->nullable();
                // }

            // if (!Schema::hasColumn('ltc_miscellaneous_exps', 'modified')) {
            //     $table->tinyInteger('modified')->default(0)->comment('0 - Not Recently Update, 1 - Recently Update')->after('status');
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltc_miscellaneous_exps');
    }
};

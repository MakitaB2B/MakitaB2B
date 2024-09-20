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
        Schema::table('dealer_masters', function (Blueprint $table) {
           
            
            //$table->longText('Address [1]')->nullable();
            //$table->longText('Address [2]')->nullable();
            //$table->longText('Address [3]')->nullable();
            //$table->longText('Address [4]')->nullable();
            //$table->string('City')->nullable();
            //$table->string('Description')->nullable();
            //$table->string('Postal/ZIP')->nullable();
            //$table->string('County')->nullable();
            //$table->string('Country')->nullable();
            //$table->string('Contact')->nullable(); // contact name
            // $table->string('Phone')->nullable();
            // $table->string('Ship Site')->nullable();
            // $table->string('Salesperson')->nullable();
            // $table->tinyInteger('GST Registered')->nullable(); 
            // $table->string('Provisional ID No')->nullable();
            // $table->date('Start Date')->nullable();
            // $table->string('GSTIN')->nullable();
            // $table->date('Registration Date')->nullable();
            // $table->tinyInteger('State Code')->nullable();
            // $table->string('Status (Active/Deactive)')->nullable();
            // $table->tinyInteger('Ship To')->nullable();
            // $table->string('status')->nullable();
            if (!Schema::hasColumn('dealer_masters', 'id')) {
            $table->id();
            $table->string('dealer_slug',50)->unique();
            $table->string('Customer')->unique()->index(); //dealer code
            $table->string('Name')->nullable();
            }
            if (!Schema::hasColumn('dealer_masters', 'E Mail ID')) {
                $table->string('E Mail ID')->nullable()->after('Name');
            }

            if (!Schema::hasColumn('dealer_masters', 'id')) {
            $table->tinyInteger('cancelled_count')->nullable(); 
            $table->enum('status',['Active','Deactive'])->default('Active')->nullable();
            $table->enum('commercial_status',['block','open'])->default('open')->nullable();
            $table->string('is_black_listed')->nullable();
            $table->longText('comments')->nullable();
            $table->string('modified_by')->nullable();
            }
          

            // $table->enum('commercial_status',['Offer Product','FOC']);
            // $table->string('dealer_code')->unique();
            // $table->string('dealer_name');
            // $table->string('state_code');
            // $table->integer('zip_code');
            // $table->string('cardinal_direction');
            // $table->string('type');
            // $table->string('is_authorized');
            // $table->string('is_black_listed');
            // $table->string('reason_to_blacklist');
            // $table->timestamps();
            if (!Schema::hasColumn('dealer_masters', 'id')) {
            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));
            $table->timestamp('updated_at')->default(date('Y-m-d H:i:s'));
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};

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
        Schema::create('asset_masters', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag',30)->unique();
            $table->enum('asset_type',['Laptop','Desktop','Mac','External Keyboard','External Mouse','External Monitor','External Hard Disk','Hotspot','Dongle']);
            $table->string('make',30);
            $table->string('model',30);
            $table->string('serial_number',30);
            $table->string('service_tag',30)->nullable();
            $table->longText('specification')->nullable();
            $table->enum('ram',['2 GB','4 GB','8 GB','16 GB','32 GB'])->nullable();
            $table->enum('hard_disk_type',['SSD','HDD'])->nullable();
            $table->enum('hard_disk_size',['256 GB','512 GB','1 TB','2 TB'])->nullable();
            $table->enum('processor',['i3','i5','i7','i9'])->nullable();
            $table->enum('operating_system_version',['Windows 10','Windows 11','iMac'])->nullable();
            $table->string('operating_system_serial_number',40)->unique()->nullable();
            $table->enum('ms_office_version',['MS Office 2013','MS Office 2016','MS Office 2019','MS Office 2021','O365'])->nullable();
            $table->string('ms_office_licence',40)->unique()->nullable();
            $table->string('vendor_name',40)->nullable();
            $table->string('invoice_number',30)->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('amount',20)->nullable();
            $table->string('warranty_period',20)->nullable();
            $table->date('warranty_expired_date',20)->nullable();
            $table->enum('system_condition',['Good','Average','Poor'])->nullable();
            $table->text('service_replacement')->nullable();
            $table->string('system_password',30)->nullable();
            $table->string('invoice_copy')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status',['Active','Scrap'])->nullable();
            $table->string('assetmaster_slug',25)->unique()->nullable();
            $table->string('updated_by',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_masters');
    }
};

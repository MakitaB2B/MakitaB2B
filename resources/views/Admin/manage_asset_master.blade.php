@extends('Admin/layout')
@section('page_title', 'Asset Master Manage | MAKITA')
@section('assetaudit-expandable','menu-open')
@section('assetaudit-expandable','active')
@section('asset_master_select','active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.css') }}">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asset Master Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/asset-master') }}">Asset Master List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Asset Master</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Operate Assets</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('asset-master.manage-asset-master-process') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="exampleAssetTagName">Asset Tag*</label>
                                            <input type="text" class="form-control" name="asset_tag"
                                                value="{{ $asset_tag }}" required id="assettag"
                                                placeholder="Enter Asset Tag">
                                            @error('asset_tag')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                            <span class="assetTagStatus"></span>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleAssetTypeName">Asset Type*</label>
                                            <select class="custom-select" name="asset_type" required>
                                                <option value="">Please Select</option>
                                                <option @if ($asset_type == 'Laptop') selected @endif value="Laptop">
                                                    Laptop</option>
                                                <option @if ($asset_type == 'Desktop') selected @endif value="Desktop">
                                                    Desktop</option>
                                                <option @if ($asset_type == 'Mac') selected @endif value="Mac">
                                                    Mac</option>
                                                <option @if ($asset_type == 'External Keyboard') selected @endif value="External Keyboard">
                                                    External Keyboard</option>
                                                <option @if ($asset_type == 'External Mouse') selected @endif value="External Mouse">
                                                    External Mouse</option>
                                                <option @if ($asset_type == 'External Monitor') selected @endif value="External Monitor">
                                                    External Monitor</option>
                                                <option @if ($asset_type == 'External Hard Disk') selected @endif value="External Hard Disk">
                                                    External Hard Disk</option>
                                                <option @if ($asset_type == 'Hotspot') selected @endif value="Hotspot">
                                                    Hotspot</option>
                                                <option @if ($asset_type == 'Dongle') selected @endif value="Dongle">
                                                    Dongle</option>
                                            </select>
                                            @error('asset_tag')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleMakeName">Make*</label>
                                            <input type="text" class="form-control" name="make"
                                                value="{{ $make }}" required id="exampleMakeName"
                                                placeholder="Enter Make">
                                            @error('make')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleModelName">Model*</label>
                                            <input type="text" class="form-control" name="model"
                                                value="{{ $model }}" required id="exampleModelName"
                                                placeholder="Enter Model">
                                            @error('model')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleSerialNumberName">Serial Number*</label>
                                            <input type="text" class="form-control" name="serial_number"
                                                value="{{ $serial_number }}" required id="exampleSerialNumberName"
                                                placeholder="Enter Serial Number">
                                            @error('serial_number')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleServiceTag">Service Tag</label>
                                            <input type="text" class="form-control" name="service_tag"
                                                value="{{ $service_tag }}" id="exampleServiceTag"
                                                placeholder="Enter Service Tag">
                                            @error('service_tag')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleRAMName">RAM</label>
                                            <select class="custom-select" name="ram">
                                                <option value="">Please Select</option>
                                                <option @if ($ram == '2 GB') selected @endif value="2 GB">
                                                    2 GB</option>
                                                <option @if ($ram == '4 GB') selected @endif value="4 GB">
                                                    4 GB</option>
                                                <option @if ($ram == '8 GB') selected @endif value="8 GB">
                                                    8 GB</option>
                                                <option @if ($ram == '16 GB') selected @endif value="16 GB">
                                                    16 GB</option>
                                                <option @if ($ram == '32 GB') selected @endif value="32 GB">
                                                    32 GB</option>
                                            </select>
                                            @error('ram')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleHardDiskType">Hard Disk Type</label>
                                            <select class="custom-select" name="hard_disk_type">
                                                <option value="">Please Select</option>
                                                <option @if ($hard_disk_type == 'SSD') selected @endif value="SSD">
                                                    SSD</option>
                                                <option @if ($hard_disk_type == 'HDD') selected @endif value="HDD">
                                                    HDD</option>
                                            </select>
                                            @error('hard_disk_type')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleHardDiskSize">Hard Disk Size</label>
                                            <select class="custom-select" name="hard_disk_size">
                                                <option value="">Please Select</option>
                                                <option @if ($hard_disk_size == '256 GB') selected @endif value="256 GB">
                                                    256 GB</option>
                                                <option @if ($hard_disk_size == '512 GB') selected @endif value="512 GB">
                                                    512 GB</option>
                                                <option @if ($hard_disk_size == '1 TB') selected @endif value="1 TB">
                                                    1 TB</option>
                                                <option @if ($hard_disk_size == '2 TB') selected @endif value="2 TB">
                                                    2 TB</option>
                                            </select>
                                            @error('hard_disk_size')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleOperatingSystemVersion">Processor</label>
                                            <select class="custom-select" name="processor">
                                                <option value="">Please Select</option>
                                                <option @if ($processor == 'i3') selected @endif value="i3">
                                                    i3</option>
                                                <option @if ($processor == 'i5') selected @endif value="i5">
                                                    i5</option>
                                                <option @if ($processor == 'i7') selected @endif value="i7">
                                                    i7</option>
                                                <option @if ($processor == 'i9') selected @endif value="i9">
                                                    i9</option>
                                            </select>
                                            @error('processor')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleOperatingSystemVersion">Operating System Version</label>
                                            <select class="custom-select" name="operating_system_version">
                                                <option value="">Please Select</option>
                                                <option @if ($operating_system_version == 'Windows 10') selected @endif value="Windows 10">
                                                    Windows 10</option>
                                                <option @if ($operating_system_version == 'Windows 11') selected @endif value="Windows 11">
                                                    Windows 11</option>
                                                <option @if ($operating_system_version == 'iMac') selected @endif value="iMac">
                                                    iMac</option>
                                            </select>
                                            @error('operating_system_version')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleOperatingSystemSerialNumber">Operating System Serial Number</label>
                                            <input type="text" class="form-control" name="operating_system_serial_number"
                                                value="{{ $operating_system_serial_number }}"  id="operatingSystemSerialNumber"
                                                placeholder="Enter Operating System Serial No.">
                                            @error('operating_system_serial_number')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                            <span class="operatingSystemSerialNumberStatus"></span>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleHardDiskType">MS Office Version</label>
                                            <select class="custom-select" name="ms_office_version">
                                                <option value="">Please Select</option>
                                                <option @if ($asset_type == 'MS Office 2013') selected @endif value="MS Office 2013">
                                                    MS Office 2013</option>
                                                <option @if ($asset_type == 'MS Office 2016') selected @endif value="MS Office 2016">
                                                    MS Office 2016</option>
                                                <option @if ($asset_type == 'MS Office 2019') selected @endif value="MS Office 2019">
                                                    MS Office 2019</option>
                                                <option @if ($asset_type == 'MS Office 2021') selected @endif value="MS Office 2021">
                                                    MS Office 2021</option>
                                                <option @if ($asset_type == 'O365') selected @endif value="O365">
                                                    O365</option>
                                            </select>
                                            @error('ms_office_version')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleMSOfficeLicence">MS Office Licence</label>
                                            <input type="text" class="form-control" name="ms_office_licence"
                                                value="{{ $ms_office_licence }}"  id="msofficelicence"
                                                placeholder="Enter MS Office Licence">
                                            @error('ms_office_licence')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                            <span class="msOfficeLicenceStatus"></span>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleVendorName">Vendor Name</label>
                                            <input type="text" class="form-control" name="vendor_name"
                                                value="{{ $vendor_name }}"  id="exampleVendorName"
                                                placeholder="Enter Vendor Name">
                                            @error('vendor_name')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInvoiceNumber">Invoice Number</label>
                                            <input type="text" class="form-control" name="invoice_number"
                                                value="{{ $invoice_number }}"  id="exampleInvoiceNumber"
                                                placeholder="Enter Invoice Number">
                                            @error('invoice_number')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInvoiceDate">Invoice Date</label>
                                            <input type="date" class="form-control" name="invoice_date"
                                                value="{{ $invoice_date }}"  id="exampleInvoiceDate"
                                                placeholder="Enter Invoice Date">
                                            @error('invoice_date')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleAmount">Amount</label>
                                            <input type="text" class="form-control" name="amount"
                                                value="{{ $amount }}"  id="exampleAmount"
                                                placeholder="Enter Amount">
                                            @error('amount')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleWarrantyPeriod">Warranty Period</label>
                                            <input type="text" class="form-control" name="warranty_period"
                                                value="{{ $warranty_period }}"  id="exampleWarrantyPeriod"
                                                placeholder="Enter Warranty Period">
                                            @error('warranty_period')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleWarrantyExpiredDate">Warranty Expired Date</label>
                                            <input type="date" class="form-control" name="warranty_expired_date"
                                                value="{{ $warranty_expired_date }}"  id="exampleWarrantyExpiredDate"
                                                placeholder="Enter Warranty Expired Date">
                                            @error('warranty_expired_date')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleSystemCondition">System Condition</label>
                                            <select class="custom-select" name="system_condition">
                                                <option value="">Please Select</option>
                                                <option @if ($system_condition == 'Good') selected @endif value="Good">
                                                    Good</option>
                                                <option @if ($system_condition == 'Average') selected @endif value="Average">
                                                    Average</option>
                                                <option @if ($system_condition == 'Poor') selected @endif value="Poor">
                                                    Poor</option>
                                            </select>
                                            @error('system_condition')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Status*</label>
                                            <select class="custom-select" name="status" required>
                                                <option value="">Please Select</option>
                                                <option @if ($status == 'Active') selected @endif value="Active">
                                                    Active
                                                </option>
                                                <option @if ($status == 'Scrap') selected @endif value="Scrap">
                                                    Scrap
                                                </option>
                                            </select>
                                            @error('status')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleSystemPassword">System Password</label>
                                            <input type="text" class="form-control" name="system_password"
                                                value="{{ $system_password }}"  id="exampleSystemPassword"
                                                placeholder="Enter System Password">
                                            @error('system_password')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleSystemPassword">Last Updated at</label>
                                            <input  class="form-control" value="{{ \Carbon\Carbon::parse($updated_at)->format('d M Y H:i:s' ) }}" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleSpecification">Specification</label>
                                            <textarea class="form-control" name="specification" placeholder="Enter Specification" id="summernote1">{{ $specification }}</textarea>
                                            @error('specification')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleServiceReplacement">Any Service / Replacement?</label>
                                            <textarea class="form-control" name="service_replacement"  placeholder="Enter IF Any Service or Replacement"
                                                 id="summernote2">{{ $service_replacement }}</textarea>
                                            @error('service_replacement')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleRemarks">Remarks</label>
                                            <textarea class="form-control" name="remarks" placeholder="Enter Remarks" id="summernote3">{{ $remarks }}</textarea>
                                            @error('remarks')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="submt">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $assetmaster_slug }}" name="assetmaster_slug" required />
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- Summernote -->
        <script src="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <script>
            $(function() {
                // Summernote
                $('#summernote1').summernote()
                $('#summernote2').summernote()
                $('#summernote3').summernote()
            });

        $(document).ready(function() {

        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $('#assettag').blur(debounce(function(){
            var assetTag = $.trim($('#assettag').val());
            if(assetTag!=''){
                $.ajax({
                        url: '/admin/asset-master/check-assettag-existence',
                        type: 'post',
                        data: 'assettag=' + assetTag + '&_token={{ csrf_token() }}',
                        success: function(data) {
                            $(".assetTagStatus").html(data);
                            if(data.indexOf("Asset Tag Not Available") > -1)
                            {
                                $("#submt").prop('disabled', true);
                            }
                            if(data.indexOf("Asset Tag Available") > -1)
                            {
                                $("#submt").prop('disabled', false);
                            }
                        }
                });
            }
        },100));
        $('#msofficelicence').blur(debounce(function(){
            var msOfficeLicence = $.trim($('#msofficelicence').val());
            if(msOfficeLicence!=''){
                $.ajax({
                        url: '/admin/asset-master/msofficelicence-existence',
                        type: 'post',
                        data: 'msOfficeLicence=' + msOfficeLicence + '&_token={{ csrf_token() }}',
                        success: function(data) {
                            $(".msOfficeLicenceStatus").html(data);
                            if(data.indexOf("MS Office Licence Not Available") > -1)
                            {
                                $("#submt").prop('disabled', true);
                            }
                            if(data.indexOf("MS Office Licence Available") > -1)
                            {
                                $("#submt").prop('disabled', false);
                            }
                        }
                });
            }
        },100));
        $('#operatingSystemSerialNumber').blur(debounce(function(){
            var operatingSystemSerialNumber = $.trim($('#operatingSystemSerialNumber').val());
            if(operatingSystemSerialNumber!=''){
                $.ajax({
                        url: '/admin/asset-master/operatingsystemserialnumber-existence',
                        type: 'post',
                        data: 'operatingsystemserialnumber=' + operatingSystemSerialNumber + '&_token={{ csrf_token() }}',
                        success: function(data) {
                            $(".operatingSystemSerialNumberStatus").html(data);
                            if(data.indexOf("OS Serial Number Not Available") > -1)
                            {
                                $("#submt").prop('disabled', true);
                            }
                            if(data.indexOf("OS Serial Number Available") > -1)
                            {
                                $("#submt").prop('disabled', false);
                            }
                        }
                });
            }
        },100));

        });

        </script>
    @endpush
@endsection

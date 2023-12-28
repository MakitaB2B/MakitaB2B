@extends('Admin/layout')
@section('page_title', 'Warranty Applications List | MAKITA')
@section('warrantyapp_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Warranty Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/warranty-applications') }}">Warranty List</a>
                            </li>
                            <li class="breadcrumb-item active">Warranty Application</li>
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
                                <h3 class="card-title">Operate Warranty Application Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Mode of Purchase</label>
                                            <input type="text" class="form-control"
                                                value="{{ $mode_of_purchase }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Purchase From</label>
                                            <input class="form-control"
                                                value="{{ $purchase_from }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Place Of Purchase</label>
                                            <input class="form-control"
                                                value="{{ $place_of_purchase }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Date of Purchase</label>
                                            <input class="form-control"
                                                value="{{ Carbon\Carbon::parse($date_of_purchase)->format('d M Y') }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Warranty Expiry Date</label>
                                            <input  class="form-control"
                                                value="{{ Carbon\Carbon::parse($warranty_expiry_date)->format('d M Y') }}" disabled>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Invoice Number</label>
                                            <input  class="form-control"
                                                value="{{ $invoice_number }}" disabled>
                                        </div>
                                        @if ($invoice_copy!='')
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Invoice Copy</label>
                                            <br>
                                            <img src="{{ asset($invoice_copy) }}"
                                                                height="80px">
                                            <p><a href="{{ asset($invoice_copy) }}"
                                                target="iframe_a" style="color: black"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        </div>
                                        @endif
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputStateName">Machine SL. Number</label>
                                            <br>
                                            <a href="{{ asset($machine_slno_photo) }}"
                                                target="iframe_a" style="color: black" title="Explore">
                                            <img src="{{ asset($machine_slno_photo) }}"
                                                                height="80px">
                                            </a>
                                        </div>
                                        @if ($comment!='')
                                        <div class="form-group col-md-12">
                                            <label>Comments</label>
                                            <textarea class="form-control"  rows="2" disabled>{{ $comment }}</textarea>
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
@endsection

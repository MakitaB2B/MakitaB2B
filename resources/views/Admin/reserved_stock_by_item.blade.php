@extends('Admin/layout')
@section('page_title', 'Reserved Stock Item | MAKITA')
@section('stock-expandable', 'menu-open')
@section('stock_select', 'active')
@section('reserved_stocks', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>Reserve Stock</h1>
                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Reserve Stock</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Reserved Stocks By Item</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <select class="custom-select" style="margin-right:10px;display:none" id="sortchild">
                                        </select>
                                        <select class="custom-select" id="stype">
                                            <option value="">Select Option</option>
                                            <option value="item">Item</option>
                                            <option value="description">Description</option>
                                            <option value="customer">Customer</option>
                                            <option value="name">Name</option>
                                        </select>
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search by Item" id="searchtxt">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default smi">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="searchresultmsg" style="margin-left: 160px"></span>
                                </div>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table class="table table-head-fixed table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Ref Type</th>
                                            <th>Order</th>
                                            <th>Customer</th>
                                            <th>Name</th>
                                            <th>Reserved</th>
                                            <th>Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
                                        @foreach ($reserveStockDetails as $key => $reservedStock)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $reservedStock->item }}</td>
                                                <td>{{ $reservedStock->itemdescription }}</td>
                                                <td>{{ $reservedStock->category }}</td>
                                                <td>{{ $reservedStock->reftype }}</td>
                                                <td>{{ $reservedStock->order }}</td>
                                                <td>{{ $reservedStock->customer }}</td>
                                                <td>{{ $reservedStock->customername }}</td>
                                                <td>{{ $reservedStock->reserved }}</td>
                                                <td>{{ Carbon\Carbon::parse($reservedStock->updated_at)->format('d M Y H:i:s') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.smi').on('click', function() {
                    let searchType = $.trim($("#stype").val());
                    if (searchType == '') {
                        $("#stype").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    } else {
                        let searchtxt = $.trim($("#searchtxt").val());
                        let searchFrom = "stockpg";
                        if (searchtxt != '' && searchtxt.length > 3) {
                            $("#searchresultmsg").text('Please Wait while processing....').css({
                                "color": "green",
                                "font-weight": "600",
                                "font-size": "11px",
                            });
                            $.ajax({
                                url: '/admin/reserve-stock-search',
                                type: 'post',
                                data: 'searchtxt=' + searchtxt + '&searchtype=' + searchType +
                                    '&_token={{ csrf_token() }}',
                                success: function(result) {
                                    $('#searchresult').html(result);
                                    $("#searchresultmsg").text('');
                                }
                            });
                        }
                        if (searchtxt.length <= 3) {
                            $("#searchresultmsg").text('Should input more than 3 character').css({
                                "color": "red",
                                "font-weight": "600",
                                "font-size": "10px"
                            });
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection

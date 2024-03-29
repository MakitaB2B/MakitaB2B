@extends('Admin/layout')
@section('page_title', 'Reserved Stock | MAKITA')
@section('stock-expandable', 'menu-open')
@section('stock_select', 'active')
@section('reserved_stocks', 'active')
@section('container')
<style>
    @media only screen and (max-width: 1040px) {
        .rescss300 {
            width:300%;
        }
    }
</style>
    <div class="content-wrapper rescss300">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                @if (session()->has('message'))
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">{{ session('message') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reserved Stocks</h1>
                    </div>
                    <div class="col-sm-6">
                        <b style="display: none; color:green" id="hm">File is large, it may take a while, please wait
                            while processing.....</b>
                        <form action="{{ route('upload-reserved-stock') }}" method="post" enctype="multipart/form-data"
                            id="suf">
                            @csrf
                            <input type="submit" value="Upload" class="btn float-right" id="submitstock">
                            <label for="inputField" class="btn btn-info float-right">Reserved File</label>
                            <input type="file" name="rscsv" id="inputField" style="display:none" required>
                        </form>
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
                                <h3 class="card-title">Reserved Stocks</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <select class="custom-select" style="margin-right:10px" id="sortby">
                                            <option value="">Sort By</option>
                                            <option value="category">Category</option>
                                            <option value="refertype">Refer Type</option>
                                        </select>
                                        <small id="fpm"></small>
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
                                        @foreach ($result as $key => $reservedStock)
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
                                <div class="d-flex justify-content-center" style="margin-top:15px">
                                    {!! $result->links() !!}
                                </div>
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
                $("#sortby").on('change', function() {
                    let sortType = $.trim($("#sortby").val());
                    if (sortType != '') {
                        $("#fpm").text('Please wait...').css({
                            "color": "#9707d8",
                            "font-weight": "600",
                            "font-size": "10px",
                        });
                        $.ajax({
                            url: '/admin/reserve-stock-filterguardian',
                            type: 'post',
                            data: 'sorttype=' + sortType + '&_token={{ csrf_token() }}',
                            success: function(result) {
                                $('#sortchild').html(result);
                                $("#fpm").text('');
                                $("#sortchild").show();
                            }
                        });
                    } else {
                        $("#sortby").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                        $("#sortchild").hide();
                    }
                });
                $("#sortchild").on('change', function() {
                    let sortType = $.trim($("#sortby").val());
                    let sortChild = $.trim($("#sortchild").val());
                    if (sortType == '') {
                        $("#sortby").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    } else if (sortChild == '') {
                        $("#sortchild").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    } else {
                        $.ajax({
                            url: '/admin/reserve-stock-filerresult',
                            type: 'post',
                            data: 'sorttype=' + sortType + '&sortchild=' + sortChild +
                                '&_token={{ csrf_token() }}',
                            success: function(result) {
                                $('#searchresult').html(result);
                            }
                        });
                    }
                });

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

                $('#submitstock').on('click', function() {
                    $("#suf").hide();
                    $("#hm").show();

                });
            });
        </script>
    @endpush
@endsection

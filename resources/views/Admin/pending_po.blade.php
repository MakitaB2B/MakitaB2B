@extends('Admin/layout')
@section('page_title', 'Pending PO | MAKITA')
@section('stock-expandable', 'menu-open')
@section('stock_select', 'active')
@section('pending_po', 'active')
@section('container')
<style>
    @media only screen and (max-width: 1040px) {
        .rescss250 {
            width:250%;
        }
    }
</style>
    <div class="content-wrapper rescss250">
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
                        <h1>ETA Enquiries</h1>
                    </div>
                    <div class="col-sm-6">
                        <b style="display: none; color:green" id="hm">File is large, it may take a while, please wait
                            while processing.....</b>
                        <form action="{{ route('upload-pending-po') }}" method="post" enctype="multipart/form-data"
                            id="suf">
                            @csrf
                            <input type="submit" value="Upload" class="btn float-right" id="submitstock">
                            <label for="inputField" class="btn btn-info float-right">Pending PO File</label>
                            <input type="file" name="ppof" id="inputField" style="display:none" required>
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
                                <h3 class="card-title"><div class="input-group input-group-sm">
                                    <select class="custom-select" id="stype">
                                        <option value="">Select Option</option>
                                        <option value="item" selected="selected">Item</option>
                                        <option value="description">Description</option>
                                    </select>
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search by Item" id="searchtxt">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default spp">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <span id="searchresultmsg"></span></h3>
                            </div>
                            <!-- ./card-header -->
                            <div class="card-body">
                                <table class="table table-head-fixed table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>ETA</th>
                                            <th>Item Desc</th>
                                            <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
                                        @php
                                        //    dd($result->toArray());
                                        @endphp
                                        @foreach ($result as $key => $pendingPO)
                                            <tr>
                                                <td>{{ $pendingPO->item }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pendingPO->duedate)->format('d M Y' ) }}</td>
                                                <td>{{ $pendingPO->itemdescription }}</td>
                                                <td>{{ $pendingPO->ordered }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center" style="margin-top:15px">
                                    <span class="paginatelink">{!! $result->links() !!}</span>
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
                   $('.spp').on('click', function() {
                    let searchType = $.trim($("#stype").val());
                    if (searchType == '') {
                        $("#stype").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    } else {
                        let searchtxt = $.trim($("#searchtxt").val());
                        let searchFrom = "stockpg";
                        if (searchtxt != '' && searchtxt.length > 0) {
                            $("#searchresultmsg").text('Please Wait while processing....').css({
                                "color": "green",
                                "font-weight": "600",
                                "font-size": "11px"
                            });
                            $.ajax({
                                url: '/admin/pending-po-search',
                                type: 'post',
                                data: 'searchtxt=' + searchtxt +  '&searchtype=' + searchType + '&_token={{ csrf_token() }}',
                                success: function(result) {
                                    $('#searchresult').html(result);
                                    $("#searchresultmsg").text('');
                                    $(".paginatelink").hide();
                                }
                            });
                        }
                        if (searchtxt.length <= 0) {
                            $("#searchresultmsg").text('Should input a character').css({
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

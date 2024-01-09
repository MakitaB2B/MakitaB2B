@extends('Admin/layout')
@section('page_title', 'Branch Stock | MAKITA')
@section('branch_stock_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Branch Stock</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Branch Stock</li>
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
                                <h3 class="card-title">Branch Stock</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search by Item" id="searchtxt">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default smi">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="searchresultmsg"></span>
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
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
                                        @foreach ($result as $key=>$modelVariantData)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{ $modelVariantData->item }}</td>
                                                        <td>{{ $modelVariantData->description }}</td>
                                                        <td>{{ $modelVariantData->total_stock }}</td>
                                                        <td><a href="{{ url('admin/branch-stock-details/') }}/{{ Crypt::encrypt($modelVariantData->pmv_slug) }}"
                                                            title="View Stock Details"> <i class="nav-icon fas fa-eye"></i></a></td>
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
            $('.smi').on('click', function() {
                let searchtxt = $.trim($("#searchtxt").val());
                if(searchtxt!='' && searchtxt.length>3){
                    $("#searchresultmsg").text('Please Wait while processing....').css({"color": "green", "font-weight": "600","font-size":"11px"});
                    $.ajax({
                    url: '/admin/stock-search',
                    type: 'post',
                    data: 'searchtxt=' + searchtxt + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#searchresult').html(result);
                        $("#searchresultmsg").text('');
                    }
                    });
                }if(searchtxt.length<3){
                    $("#searchresultmsg").text('Should input more than 3 character').css({"color": "red", "font-weight": "600","font-size":"10px"});
                }
            });
        });
    </script>
    @endpush
@endsection

@extends('Admin/layout')
@section('page_title', 'Dealer Master | MAKITA')
@section('dealer-master-expandable', 'menu-open')
@section('dealer-master_select', 'active')
@section('dealer_master_select', 'active')
@section('container')
    <div class="content-wrapper rescss">
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
                        <h1>Dealer Master</h1>
                    </div>
                    <div class="col-sm-6">
                        <b style="display: none; color:green" id="hm">File is large, it may take a while, please wait
                            while processing.....</b>
                        <form action="{{ route('upload-daily-stock') }}" method="post" enctype="multipart/form-data"
                            id="suf">
                            @csrf
                            <input type="submit" value="Upload" class="btn float-right" id="submitstock">
                            <label for="inputField" class="btn btn-info float-right">Stocks File</label>
                            <input type="file" name="mycsv" id="inputField" style="display:none" required>
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
                                <h3 class="card-title">Dealer Master</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <select class="custom-select" id="stype">
                                            <option value="">Select Option</option>
                                            <option value="item" selected="selected">Item</option>
                                            <option value="description">Description</option>
                                        </select>
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
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th>Total Main Stock</th>
                                            <th>Reserved</th>
                                            <th>Sellable</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
                                        {{-- @foreach ($result as $key => $modelVariantData)
                                            @php
                                                $mainStock=(int)($modelVariantData->cb01)+ (int)($modelVariantData->dl01)+(int)($modelVariantData->gh01)+(int)($modelVariantData->gj01)+(int)($modelVariantData->id01)+(int)($modelVariantData->jm01)+(int)($modelVariantData->ka01)+(int)($modelVariantData->kl01)+(int)($modelVariantData->mh01)+(int)($modelVariantData->pn01)+(int)($modelVariantData->py01)+(int)($modelVariantData->rd01)+(int)($modelVariantData->tn01)+(int)($modelVariantData->vd01)+(int)($modelVariantData->wb01);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ url('admin/branch-stock-details/') }}/{{ Crypt::encrypt($modelVariantData->item) }}"
                                                        title="View Stock Details" style="color:#00909E"> <strong>{{ $modelVariantData->item }}</strong></a>
                                                </td>
                                                <td>{{ $modelVariantData->description }}</td>
                                                <td>{{ $mainStock}}</td>
                                                @php
                                                    $totalReservedQty = 0;
                                                    $reserveQtyStr = $modelVariantData->reservedStock->pluck('reserved')->implode('+');
                                                    $explodeRQ = explode('+', $reserveQtyStr);
                                                    foreach ($explodeRQ as $rq) {
                                                        $totalReservedQty += (int) $rq;
                                                    }
                                                @endphp
                                                <td>
                                                    @if ($totalReservedQty>0)
                                                    <a href="{{ url('admin/reserve-stock-fetchby-item/') }}/{{ Crypt::encrypt($modelVariantData->item) }}"
                                                        title="View Reserved Details" target="_blank" style="color:#00909E">
                                                        <strong>{{ $totalReservedQty }}</strong>
                                                    </a>
                                                    @else
                                                    <i style="color:#dc129c">{{ $totalReservedQty }}</i>
                                                    @endif
                                                </td>
                                                <td>{{($mainStock - $totalReservedQty)}}</td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center" style="margin-top:15px">
                                    {{-- {!! $result->links() !!} --}}
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
                                url: '/admin/stock-search',
                                type: 'post',
                                data: 'searchtxt=' + searchtxt + '&searchtype=' + searchType +
                                    '&searchFrom=' + searchFrom +
                                    '&_token={{ csrf_token() }}',
                                success: function(result) {
                                    $('#searchresult').html(result);
                                    $("#searchresultmsg").text('');
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

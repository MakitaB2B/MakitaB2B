@extends('Admin/layout')
@section('page_title', 'Stock List | MAKITA')
@section('branch_stock_select', 'active')
@section('container')
    <style>
        .mainstock {
            background: #249303;
        }

        .demoin {
            background: darkorange;
        }

        .demoout {
            background: orangered
        }

        .serviceroom {
            background: #009b9b;
        }

        .showroom {
            background: #8e2fa0;
        }

        .bstockheader {
            color: #fff;
            padding: 2px;
            border-radius: 1px;
        }
    </style>
    <div class="content-wrapper">
        @push('styles')
            <!-- DataTables -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet"
                href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stocks</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>{{ $mvDetails[0]->item }}</strong>, <small>Total:
                                        {{ $mvDetails[0]->total_stock }}</small></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="mainstock bstockheader">Main Stock</th>
                                            <th class="demoin bstockheader">Demo In</th>
                                            <th class="demoout bstockheader">Demo Out</th>
                                            <th class="serviceroom bstockheader">Service Room</th>
                                            <th class="showroom bstockheader">Show Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockDetails as $list)
                                            <tr>
                                                <td class="getSlug"><span
                                                    style="display: none">{{ $list->fscbs_slug }}-</span> {{$loop->iteration}}</td>
                                                <td contenteditable="true"><span
                                                        style="display: none">main-</span>{{ $list->place_short_code }}:
                                                    <b>{{ $list->main }}</b></td>
                                                <td contenteditable="true"><span
                                                    style="display: none">demo_in-</span>{{ $list->place_short_code }}: <b>{{ $list->demo_in }}</b></td>
                                                <td contenteditable="true"><span
                                                    style="display: none">demo_out-</span>{{ $list->place_short_code }}: <b>{{ $list->demo_out }}</b></td>
                                                <td contenteditable="true"><span
                                                    style="display: none">service_room-</span>{{ $list->place_short_code }}: <b>{{ $list->service_room }}</b></td>
                                                <td contenteditable="true"><span
                                                    style="display: none">show_room-</span>{{ $list->place_short_code }}: <b>{{ $list->show_room }}</b></td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th class="mainstock bstockheader">Main Stock</th>
                                            <th class="demoin bstockheader">Demo In</th>
                                            <th class="demoout bstockheader">Demo Out</th>
                                            <th class="serviceroom bstockheader">Service Room</th>
                                            <th class="showroom bstockheader">Show Room</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- Page specific script -->
        <script>
            let stockLastString;
            $('td').on('click', function() {
                stockLastString = $(this).text();
            });
            $("td[contenteditable=true]").blur(function() {
                var stockValue = $(this).text();
                var fbsSlugStr = $(this).closest('tr').find('td.getSlug').text();
                let fbsSlugSplit = fbsSlugStr.split('-');
                let fbsSlug = $.trim(fbsSlugSplit[0]);

                var splitStockUpdatedStr=stockValue.split(":");
                var stockUpdatedVal=$.trim(splitStockUpdatedStr[1]);

                var splitStockLastString=stockLastString.split(":");
                var stockLastVal=$.trim(splitStockLastString[1]);

                if(stockUpdatedVal!=stockLastVal){
                    $.post('/admin/update-stock', 'stockValue=' + stockValue + '&fbsSlug=' + fbsSlug + '&_token={{ csrf_token() }}', function(data) {
                    if (data != '') {
                        // message_status.show();
                        // message_status.text(data);
                        // //hide the message
                        // setTimeout(function() {
                        //     message_status.hide()
                        // }, 1000);
                        console.log(data);
                    }
                    });
                }
            });

            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
    @endpush
@endsection

@extends('Admin/layout')
@section('page_title', 'Asset Master List | MAKITA')
@section('assetaudit-expandable','menu-open')
@section('assetaudit-expandable','active')
@section('asset_master_select','active')
@section('container')
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
                        <a href="{{ url('admin/asset-master/manage-asset-master') }}"><button type="button"
                                class="btn btn-block btn-primary">Add Assets</button></a>
                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Asset Master</li>
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
                                <h3 class="card-title">Asset Master List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Asset Tag</th>
                                            <th>Type</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Serial No.</th>
                                            <th>Service Tag</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assetMasterList as $key => $list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $list->asset_tag }}</td>
                                                <td>{{ $list->asset_type }}</td>
                                                <td>{{ $list->make }}</td>
                                                <td>{{ $list->model }}</td>
                                                <td>{{ $list->serial_number }}</td>
                                                <td>{{ $list->service_tag }}</td>
                                                <td>{{ $list->status === 'Active' ? "Active" : "Scrap" }}</td>
                                                <td>{{$list->employee->full_name}}</td>
                                                <td><a href="{{ url('admin/asset-master/manage-asset-master/') }}/{{ Crypt::encrypt($list->assetmaster_slug) }}"
                                                        title="Edit"> <i class="nav-icon fas fa-edit"></i></a></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Asset Tag</th>
                                            <th>Type</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Serial No.</th>
                                            <th>Service Tag</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Action</th>
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

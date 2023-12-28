@extends('Admin/layout')
@section('page_title', 'Warranty Applications | MAKITA')
@section('warrantyapp_select', 'active')
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
                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Warranty Applications</li>
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
                                <h3 class="card-title">Warranty Applications List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Mode</th>
                                            <th>Seller</th>
                                            <th>Model</th>
                                            <th>Invoice</th>
                                            <th>SL. No</th>
                                            <th>Date Of Purchase</th>
                                            <th>Expary Date</th>
                                            <th>Status</th>
                                            <th>App-Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($warrantyAppData as $key => $list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $list->mode_of_purchase }}</td>
                                                <td>{{ $list->purchase_from }}</td>
                                                <td>{{ $list->model->pluck('model_number')->implode('') }}</td>
                                                <td>{{ $list->invoice_number }}</td>
                                                <td>{{ $list->machine_serial_number }}</td>
                                                <td>{{ Carbon\Carbon::parse($list->date_of_purchase)->format('d M Y') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($list->warranty_expiry_date)->format('d M Y') }}
                                                </td>
                                                <td>{{ $list->warranty_status === 1 ? 'In-Warranty' : 'Expired' }}</td>
                                                <td>
                                                    <select class="appstatus">
                                                        <option></option>
                                                        <option value="in-review"
                                                            {{ $list->application_status == 'in-review' ? 'selected' : '' }}>
                                                            In-Review</option>
                                                        <option value="accepted"
                                                            {{ $list->application_status == 'accepted' ? 'selected' : '' }}>
                                                            Accepted</option>
                                                        <option value="rejected"
                                                            {{ $list->application_status == 'rejected' ? 'selected' : '' }}>
                                                            Rejected</option>
                                                    </select>
                                                </td>
                                                <td><a href="{{ url('admin/warranty/manage-warranty-application/') }}/{{ Crypt::encrypt($list->warranty_slug ) }}"
                                                        title="View"> <i class="nav-icon fas fa-eye"></i></a></td>
                                                 <input type="hidden" class="slug" value={{$list->warranty_slug }} />
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Mode</th>
                                            <th>Seller</th>
                                            <th>Model</th>
                                            <th>Invoice</th>
                                            <th>SL. No</th>
                                            <th>Date Of Purchase</th>
                                            <th>Expary Date</th>
                                            <th>Status</th>
                                            <th>App-Status</th>
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
                $(document).ready(function() {
                    $('.appstatus').on('change', function() {
                        let status = $(this).val();
                        let slug = $(this).closest('tr').find('.slug').val();
                        $.ajax({
                            url: '/admin/warranty/change-warranty-applications-status',
                            type: 'post',
                            data: 'status=' + status + '&slug=' + slug +
                                '&_token={{ csrf_token() }}',
                            success: function(result) {
                                console.log(result);
                            }
                        });
                    });
                });


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

@extends('Admin/layout')
@section('page_title', 'Service List | MAKITA')
@section('service_management_select', 'active')
@section('container')
    <!-- The Team Modal -->
    <div class="modal" id="estimationDate">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="exampleInputTeamName">Estimation Date(Informed to customer)(B)*</label>
                                <input type="datetime-local" class="form-control" name="name" required
                                    id="exampleInputTeamName">
                                @error('name')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- /.card-body -->
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
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
                        <a href="{{ url('admin/service-management/create-sr') }}"><button type="button"
                                class="btn btn-block btn-primary">Create SR</button></a>
                    </div>
                    <div class="col-sm-10">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Service Management</li>
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
                                <h3 class="card-title">Service List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>TRN</th>
                                            <th>Date</th>
                                            <th>Branch</th>
                                            <th>Repairer</th>
                                            <th>Deler/Customer</th>
                                            <th>Phone</th>
                                            <th>Model & SL</th>
                                            <th>Received Date(A)</th>
                                            <th>Estimation Date(B)</th>
                                            <th>Duration A-B</th>
                                            <th>Customer Confirm</th>
                                            <th>Repair Completed</th>
                                            <th>Handed Over</th>
                                            <th>Status</th>
                                            <th>Total Hours</th>
                                            <th>Within 48H</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($roleList as $key => $list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $list->name  }}</td>
                                                <td>{{ $list->status === 1 ? "Active" : "De-Active" }}</td>
                                                <td>{{ $list->created_by  }}</td>
                                                <td>
                                                    <a href="{{ url('admin/roles/manage-role/') }}/{{ Crypt::encrypt($list->role_slug) }}"
                                                        title="Roles"> <i class="nav-icon fas fa-edit" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                        <tr>
                                            <td>1</td>
                                            <td>1-Apr-24</td>
                                            <td>Bangalore HO</td>
                                            <td>Dasarath M</td>
                                            <td>Ganesh Enterprises</td>
                                            <td>9008363273</td>
                                            <td>EK7301</td>
                                            <td>4/1/24 10:00 AM</td>
                                            <td>4/1/24 10:30 AM</td>
                                            <td>0</td>
                                            <td>4/1/24 10:30 AM</td>
                                            <td>4/1/24 11:30 AM</td>
                                            <td>1</td>
                                            <td>Delivered</td>
                                            <td>1</td>
                                            <td>OK</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>5-Apr-24</td>
                                            <td>Bangalore HO</td>
                                            <td>Dasarath M</td>
                                            <td>Ganesh Enterprises</td>
                                            <td>9008363273</td>
                                            <td>EK7301</td>
                                            <td>4/1/24 10:00 AM</td>
                                            <td><button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                                    data-target="#estimationDate">Estimation <i class="nav-icon fas fa-plus"
                                                        aria-hidden="true"></i></button></td>
                                            <td>Null</td>
                                            <td>Null</td>
                                            <td>Null</td>
                                            <td>Null</td>
                                            <td>Null</td>
                                            <td>Null</td>
                                            <td>Null</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>TRN</th>
                                            <th>Date</th>
                                            <th>Branch</th>
                                            <th>Repairer</th>
                                            <th>Deler/Customer</th>
                                            <th>Phone</th>
                                            <th>Model & SL</th>
                                            <th>Received Date(A)</th>
                                            <th>Estimation Date(B)</th>
                                            <th>Duration A-B</th>
                                            <th>Customer Confirm</th>
                                            <th>Repair Completed</th>
                                            <th>Handed Over</th>
                                            <th>Status</th>
                                            <th>Total Hours</th>
                                            <th>Within 48H</th>
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

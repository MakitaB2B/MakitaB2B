@extends('Admin/layout')
@section('page_title', 'Business Trips Requests Mangers Panel | MAKITA')
@section('travelmanagement-expandable','menu-open')
@section('travelmanagement-expandable','active')
@section('ltcmanager-trips-select','active')
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
                    <div class="col-sm-6">
                        <h1>LTC Requests For Manger`s Approval</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">LTC Request For Manager Approval</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Itc Claim Id</th>
                                            <th>Applied By</th>
                                            <th>Ltc Month</th>
                                            <th>Ltc Year</th>
                                            {{-- <th>Number of Days</th>
                                            <th>Place of Visit</th>
                                            <th>Purpuse of Visit</th> --}}
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $key => $list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $list->ltc_claim_id }}</td>
                                                <td>{{ $list->employee->full_name }}</td>
                                                <td>{{ $list->ltc_month }}</td>
                                                <td>{{ $list->ltc_year }}</td>
                                                <td>{{ $list->date }}</td>
                                                <td>{{ $list->status == 0 ? 'In-Review' : ($list->status == 1 ? 'Approved' : 'Rejected')}}

                                                    {{-- @if ($list->status == 0)
                                                    <select class="btappstatus">
                                                        <option value="in-review"
                                                            {{ $list->status == 0 ? 'selected' : '' }}>
                                                            In-Review</option>
                                                        <option value="1"
                                                            {{ $list->status == 1 ? 'selected' : '' }}>
                                                            Approved</option>
                                                        <option value="2"
                                                            {{ $list->application_status == '2' ? 'selected' : '' }}>
                                                            Rejected</option>
                                                    </select>
                                                    @elseif ($list->status == 1)
                                                    <p style="color:green">Approved</p>
                                                    @elseif ($list->status == 2)
                                                    <p style="color:red">Rejected</p>
                                                    @endif --}}
                                                </td>
                                                <td>Action</td>
                                                {{-- <td><a href="{{ url('admin/city/manage-city/') }}/{{ Crypt::encrypt($list->city_slug) }}"
                                                        title="Edit"> <i class="nav-icon fas fa-edit"></i></a></td>
                                                <input type="hidden" class="btaslug" value="{{$list->bta_slug }}" /> --}}
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Itc Claim Id</th>
                                            <th>Applied By</th>
                                            <th>Ltc Month</th>
                                            <th>Ltc Year</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            {{-- <th>Applied By</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Number of Days</th>
                                            <th>Place of Visit</th>
                                            <th>Purpuse of Visit</th>
                                            <th>Status</th>
                                            --}}
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
                    $('.btappstatus').on('change', function() {
                        let status = $(this).val();
                        let $this = $(this);
                        if (status == 1 || status == 2) {
                            if (confirm("Are you sure you want to change this?")) {
                                let btaSlug = $this.closest('tr').find('.btaslug').val();
                                let $statusCell = $this.closest('tr').find('td:nth-child(8)');
                                // Show "Please Wait" message
                                $statusCell.html('<p style="color:green">Please Wait &#9995; ...</p>');

                                $.ajax({
                                    url: '/admin/travelmanagement/change-bta-applications-status-manager-approval',
                                    type: 'post',
                                    data: {
                                        status: status,
                                        btaSlug: btaSlug,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(result) {
                                        // console.log(result);
                                        // Replace "Please Wait" with final status
                                        if (status == 1) {
                                            $statusCell.html('<p style="color:green">Accepted &#128077;</p>');
                                        } else if (status == 2) {
                                            $statusCell.html('<p style="color:red">Rejected  &#128078;</p>');
                                        }
                                    },
                                    error: function(err) {
                                        alert('Error in updating status.');
                                        console.error(err);
                                        // Optionally hide the "Please Wait" message on error
                                        $statusCell.html('<p style="color:red">Failed to update. Try again.</p>');
                                    }
                                });
                            } else {
                                return false;
                            }
                        } else {
                            alert('Please Select A Correct Value');
                        }
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

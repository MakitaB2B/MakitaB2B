@extends('Admin/layout')
@section('page_title', 'Service List | MAKITA')
@section('service_management_select', 'active')

@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1>Tools Repair Filter List</h1>
                    </div>
                    <div class="col-sm-6">
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
                                <h3 class="card-title" style="font-size: 17px; font-weight: 600; line-height: 0; margin: 9px 0 9px 0; color: #008290;">
                                    Type: {{$filter_type}},
                                    Year: {{ $filter_year}},
                                    Month: {{ Carbon\Carbon::create()->month($filter_month)->format('F') }}
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TRN</th>
                                            <th>SR Date</th>
                                            <th>Branch</th>
                                            <th>Deler/Customer</th>
                                            <th>Model</th>
                                            <th>Cost Estimation</th>
                                            <th>Status</th>
                                            <th>Warranty Status</th>
                                            <th>Warranty Last Date</th>
                                            <th>Within 48H</th>
                                            <th>Wait Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filteredDataRepairServices as $key => $list)
                                            @php
                                                $status = match ($list->status) {
                                                    0 => 'New Case',
                                                    1 => 'Repairer Assigned',
                                                    2 => 'Estimation Shared',
                                                    3 => 'Estimation Approved By Customer',
                                                    4 => 'Estimation Rejected By Customer',
                                                    5 => 'Repair Completed yet to deliverd',
                                                    6 => 'Deliverd',
                                                    7 => 'Closed',
                                                    default => 'Something Wrong',
                                                };
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{ url('admin/service-management/manage-service-requiest/') }}/{{ Crypt::encrypt($list->sr_slug) }}"
                                                        title="Manage SR">{{ $list->trn }}</a></td>
                                                <td>{{ \Carbon\Carbon::parse($list->sr_date)->format('d M Y, H:i:s A') }}
                                                </td>
                                                <td>{{ $list->center_name }}</td>
                                                <td>{{ $list->delear_customer_name }}</td>
                                                <td>{{ $list->model }}</td>
                                                <td>{{ $list->cost_estimation }}</td>
                                                <td>{{ $status }}</td>
                                                <td>
                                                    @if (\Carbon\Carbon::parse($list->warranty_expiry_date)->lte(\Carbon\Carbon::now()))
                                                        <p style="color:red;font-size: 17px;font-weight: 600;">Out
                                                            of-Warranty</p>
                                                    @else
                                                        <p style="color:#0fb904;font-size: 17px;font-weight: 600;">
                                                            In-Warrant</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($list->warranty_expiry_date)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    @if ($list->total_hour_for_repair > 2880)
                                                        <p style="color:red;font-size: 17px;font-weight: 600;">No</p>
                                                    @else
                                                        <p style="color:#0fb904;font-size: 17px;font-weight: 600;">Yes</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($list->total_hour_for_repair != null)
                                                        @php
                                                            $totalHoursForRepair = $list->total_hour_for_repair;
                                                            $hours = floor($totalHoursForRepair / 60);
                                                            $minutes = $totalHoursForRepair % 60;
                                                        @endphp
                                                        {{ $hours . ' hours' . ':' . $minutes . ' mins' }}
                                                    @endif
                                                    @if ($list->receive_date_time != null && $list->estimation_date_time == null)
                                                        @php
                                                            $totalHoursForRepair = now()->diffInMinutes(
                                                                $list->receive_date_time,
                                                            );
                                                            $hours = floor($totalHoursForRepair / 60);
                                                            $minutes = $totalHoursForRepair % 60;
                                                        @endphp
                                                        {{ $hours . ' hours' . ':' . $minutes . ' mins' }}
                                                    @endif
                                                    @if (
                                                        $list->est_date_confirm_cx != null &&
                                                            $list->repair_complete_date_time == null &&
                                                            $list->status != 4 &&
                                                            $list->status != 7)
                                                        @php
                                                            $totalHoursForRepair = now()->diffInMinutes(
                                                                $list->est_date_confirm_cx,
                                                            );
                                                            $hours = floor($totalHoursForRepair / 60);
                                                            $minutes = $totalHoursForRepair % 60;
                                                        @endphp
                                                        {{ $hours . ' hours' . ':' . $minutes . ' mins' }}
                                                    @endif
                                                    @if ($list->duration_a_b != null && $list->status == 2)
                                                        @php
                                                            $durationAB = $list->duration_a_b;
                                                            $hours = floor($durationAB / 60);
                                                            $minutes = $durationAB % 60;
                                                        @endphp
                                                        {{ $hours . ' hours' . ':' . $minutes . ' mins' }}
                                                    @endif
                                                    @if ($list->repair_complete_date_time == null && $list->status == 7)
                                                        <p style="color:red;font-size: 17px;font-weight: 600;">Rejected By
                                                            CX</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>TRN</th>
                                            <th>SR Date</th>
                                            <th>Branch</th>
                                            <th>Deler/Customer</th>
                                            <th>Model</th>
                                            <th>Cost Estimation</th>
                                            <th>Status</th>
                                            <th>Warranty Status</th>
                                            <th>Warranty Last Date</th>
                                            <th>Within 48H</th>
                                            <th>Wait Time</th>
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

        <!-- Page specific script -->
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
@endsection

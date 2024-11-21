@extends('Admin/layout')
@section('page_title', 'Service List | MAKITA')
@section('service_management_select', 'active')
<style>
    .makitatiltcolur {
        background: #008290 !important;
    }
     .makitatiltcolurtext{
        color:#008290 !important;
        text-shadow: 2px 2px 9px #008290;

    }

    .mrsmthead {
        background: #008290;
        color: #fff;
    }

    .mrsm {
        color: #008290;
        font-size: 19px;
        font-weight: 600;
        border: 1px solid #000000 !important;
    }

    .mrsmthead th.repair-status {
        border: 2px solid #03c8dd;
        /* Add border */
    }

    .repair-status-label {
        text-align: center;
        font-weight: bold;
        border: 2px solid #03c8dd !important;
    }

    .thns {
        background: #fff;
        border: none;
    }

    .rt-status-label {
        text-align: center;
        font-weight: bold;
        border: 2px solid #4eeeff !important;
    }

    .mrsmthead th.repair-time {
        border: 2px solid #4eeeff;
        /* Add border */
    }
</style>
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
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1>Tools Repair SR List</h1>
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
                    <div class="col-6" id="accordion">
                        <div class="card card-primary ">
                            <div class="card-header makitatiltcolur">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                        <i class="fa fa-file-excel" aria-hidden="true"></i> Export Data To Excel
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion">

                                <form action="{{ route('service-management.export-asm-report-exel') }}" method="post">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="fromDate">From Date*</label>
                                                <input type="date" name="asmfrom_date" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">To Date*</label>
                                                <input type="date" name="asmto_date" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="">Service Center*</label>
                                                <select class="custom-select" name="service_center" id="state" required>
                                                    <option value="">Please Select Center</option>
                                                    <option value="26">All Service Center</option>
                                                    @foreach ($allServiceCenter as $serviceCenterList)
                                                        <option value="{{ $serviceCenterList->fsc_slug }}">
                                                            {{ $serviceCenterList->center_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @csrf
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info">Export To EXCEL</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-6" id="mswr">
                        <div class="card card-info ">
                            <div class="card-header makitatiltcolur">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                        <i class="fa fa-flag-checkered" aria-hidden="true"></i> MONTHLY STATUS WISE RESULT
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#mswr">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="fromDate">Year*</label>
                                            <select class="custom-select reportyear">
                                                <option value="">Please A Year</option>
                                                @for ($i = 2020; $i < 2025; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Month</label>
                                            <select class="custom-select reportmonth">
                                                <option value="">Please Select Month</option>
                                                <option value="15">All Month</option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Service Center*</label>
                                            <select class="custom-select reportsc" name="service_center" id="state"
                                                required>
                                                <option value="">Please Select Center</option>
                                                <option value="26">All Service Center</option>
                                                @foreach ($allServiceCenter as $serviceCenterList)
                                                    <option value="{{ $serviceCenterList->fsc_slug }}">
                                                        {{ $serviceCenterList->center_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info asmmonthreport">Generate Report</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p style="font-size: 15px; font-weight: 600; line-height: 0;">Branch: <span
                                        id="mswrbranch">All</span>, Year: <span
                                        id="mswryear">{{ Carbon\Carbon::now()->format('Y') }}</span>
                                        <span id="mswrmontsent" style="display: none"> & Month: <span id="mswrmonthval"></span>  </span>
                                </p>
                                <table class="table table-bordered table-striped  reporttable"
                                    style="border-collapse: unset !important;">
                                    <thead class="mrsmthead">
                                        <tr style="line-height: 1;">
                                            <th colspan="4" class="thns"></th>
                                            <th colspan="4" class="rt-status-label">Time</th>
                                            <th colspan="6" class="repair-status-label">Repair Status</th>
                                        </tr>
                                        <tr>
                                            <th>Month</th>
                                            <th>RECEIVED</th>
                                            <th>Total Repaired</th>
                                            <th>Pending</th>
                                            <th class="repair-time">Less than 48H </th>
                                            <th class="repair-time">Less than 72H</th>
                                            <th class="repair-time">Less than 96H</th>
                                            <th class="repair-time"> >96H </th>
                                            <th class="repair-status">Received</th>
                                            <th class="repair-status">Estimation Shared</th>
                                            <th class="repair-status">Repair Confirmed</th>
                                            <th class="repair-status">Repair Completed</th>
                                            <th class="repair-status">Delivered</th>
                                        </tr>
                                    </thead>
                                     <tbody id="mswrfr">
                                        @foreach ($monthlyReport as $mrData)
                                            <tr>
                                                <td class="mrsm">{{ $mrData->month }}</td>
                                                <td class="mrsm">{{ $mrData->total_services }}</td>
                                                <td class="mrsm">{{ $mrData->total_repaired }}</td>
                                                <td class="mrsm"><a
                                                        href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('pending') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                        title="Click to explore pending data" target="_blank" class="makitatiltcolurtext"> {{ $mrData->total_pending }}
                                                    </a>
                                                </td>
                                                <td class="mrsm"><a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('lessthan48hours') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore less than 48 hours data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->total_less_than_48_hours }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('lessthan72hours') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore less than 72 hours data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->total_less_than_72_hours }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('lessthan96hours') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore less than 96 hours data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->total_less_than_96_hours }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('greaterthan96hours') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore greater than 96 hours data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->total_greater_than_96_hours }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('received') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore Total Received data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->total_received }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('estimationshared') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore Estimation Shared data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->estimation_shared }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('repairconfirmed') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore Repaired Confirmed data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->repair_confirmed }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('repaircompleted') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore Repair completed data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->repair_completed }}
                                                    </a>
                                                </td>
                                                <td class="mrsm">
                                                    <a
                                                    href="{{ url('admin/service-management/filter/') }}/{{ Crypt::encrypt('delivered') }}/{{ Crypt::encrypt($mrData->month) }}"
                                                    title="Click to explore Delivered data" target="_blank" class="makitatiltcolurtext">
                                                    {{ $mrData->delivered }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="repairtime_chart" style="width: 100%; width:950px;height: 450px;"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-12">
                        <div class="card">
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
                                        @foreach ($toolsServiceList as $key => $list)
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
                                            <td>{{ $key+1 }}</td>
                                            <td><a href="{{ url('admin/service-management/manage-service-requiest/') }}/{{ Crypt::encrypt($list->sr_slug) }}"
                                                title="Manage SR">{{ $list->trn }}</a></td>
                                            <td>
                                                @php
                                                $receiveDateTime = \Carbon\Carbon::parse($list->sr_date);
                                                if ($receiveDateTime->hour == 0) {
                                                    $receiveDateTime->addHours(12);
                                                    $receivedAt=$receiveDateTime->format('d M Y, h:i:s A');
                                                }else{
                                                    $receivedAt=$receiveDateTime->format('d M Y, h:i:s A');
                                                }
                                                @endphp
                                                {{ $receivedAt }}
                                            </td>
                                            <td>{{ $list->fscBranch->center_name }}</td>
                                            <td>{{ $list->delear_customer_name }}</td>
                                            <td>{{ $list->model }}</td>
                                            <td>{{ $list->cost_estimation }}</td>
                                            <td>{{ $status }}</td>
                                            <td>
                                                @if ($list->warranty_expiry_date==NULL)
                                                    <p style="color:#6a5d01;font-size: 15px;font-weight: 600;">Not Registered</p>
                                                @else
                                                
                                                @if (\Carbon\Carbon::parse($list->waranty->warranty_expiry_date)-> lte(\Carbon\Carbon::now()))
                                                <p style="color:red;font-size: 17px;font-weight: 600;">Out of-Warranty</p>
                                               @else
                                               <p style="color:#0fb904;font-size: 17px;font-weight: 600;">In-Warrant</p>
                                               @endif
                                               
                                               @endif
                                               
                                            </td>
                                            <td>
                                                    @if ($list->warranty_expiry_date==NULL)
                                                    <p style="color:#6a5d01;font-size: 15px;font-weight: 600;">Not Registered</p>
                                                    @else
                                                    {{ \Carbon\Carbon::parse($list->waranty->warranty_expiry_date)->format('d M Y') }}
                                                    @endif
                                            </td>
                                            <td>
                                                @if ($list->total_hour_for_repair>2880)
                                                <p style="color:red;font-size: 17px;font-weight: 600;">No</p>
                                                @else
                                                <p style="color:#0fb904;font-size: 17px;font-weight: 600;">Yes</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->total_hour_for_repair != NULL)
                                                @php
                                                $totalHoursForRepair = $list->total_hour_for_repair;
                                                $hours = floor($totalHoursForRepair / 60);
                                                $minutes = $totalHoursForRepair % 60;
                                                @endphp
                                                {{ $hours.' hours'. ':' . $minutes.' mins' }}
                                                @endif
                                                @if($list->receive_date_time != NULL && $list->estimation_date_time == NULL)
                                                @php
                                                $totalHoursForRepair = now()->diffInMinutes($list->receive_date_time);
                                                $hours = floor($totalHoursForRepair / 60);
                                                $minutes = $totalHoursForRepair % 60;
                                                @endphp
                                                {{ $hours.' hours'. ':' . $minutes.' mins' }}
                                                @endif
                                                @if($list->est_date_confirm_cx != NULL && $list->repair_complete_date_time == NULL && $list->status!=4 && $list->status!=7)
                                                @php
                                                $totalHoursForRepair = now()->diffInMinutes($list->est_date_confirm_cx);
                                                $hours = floor($totalHoursForRepair / 60);
                                                $minutes = $totalHoursForRepair % 60;
                                                @endphp
                                                {{ $hours.' hours'. ':' . $minutes.' mins' }}
                                                @endif
                                                @if($list->duration_a_b!= NULL && $list->status==2)
                                                @php
                                                $durationAB = $list->duration_a_b;
                                                $hours = floor($durationAB / 60);
                                                $minutes = $durationAB % 60;
                                                @endphp
                                                {{ $hours.' hours'. ':' . $minutes.' mins' }}
                                                @endif
                                                @if($list->repair_complete_date_time== NULL && $list->status==7)
                                                <p style="color:red;font-size: 17px;font-weight: 600;">Rejected By CX</p>
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
        <script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Page specific script -->
        <script>
        $(document).ready(function() {
                $('.asmmonthreport').on('click', function() {
                    let reportYear = $.trim($(".reportyear").val());
                    let reportMonth = $.trim($(".reportmonth").val());
                    let reportMonthText = $(".reportmonth option:selected").text();
                    let reportServiceCenter = $.trim($(".reportsc").val());
                    let reportSCText = $(".reportsc option:selected").text();

                    if (reportYear == '') {
                        $(".reportyear").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    }
                    if (reportMonth == '') {
                        $(".reportmonth").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    }
                    if (reportServiceCenter == '') {
                        $(".reportsc").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    }
                    if (reportYear != '' && reportMonth != '' && reportServiceCenter != '') {
                        $.ajax({
                            url: '/admin/service-management/generate-asm-report',
                            type: 'post',
                            data: 'reportYear=' + reportYear + '&reportMonth=' + reportMonth +
                                '&reportServiceCenter=' + reportServiceCenter +
                                '&_token={{ csrf_token() }}',
                            success: function(result) {
                                $('#mswrfr').html(result);
                                
                                $('#mswrbranch').html(reportSCText);
                                $('#mswryear').html(reportYear);
                                $('#mswrmontsent').show();
                                $('#mswrmonthval').html(reportMonthText);
                            }
                        });

                    }

                });

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
            
         // Chart For Month wise service time

            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                fetch('/admin/service-management/generate-asm-report-graph')
                    .then(response => response.json())
                    .then(data => {
                        const chartData = [
                            ['Month', 'Pending', '< 48 hours', '48 - 72 hours', '72 - 96 hours', '> 96 hours', {
                                role: 'tooltip',
                                p: {
                                    html: true
                                }
                            }]
                        ];
                        const monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV",
                            "DEC"
                        ];

                        data.forEach(item => {
                            const totalCases = item.total_pending + item.total_less_than_48_hours +
                                item.total_between_48_and_72_hours + item.total_between_72_and_96_hours +
                                item.total_greater_than_96_hours;

                            const calculatePercentage = (count) => {
                                return totalCases === 0 ? '0.00' : ((count / totalCases) * 100).toFixed(2);
                            };

                            const pendingPercentage = calculatePercentage(item.total_pending);
                            const lessThan48HoursPercentage = calculatePercentage(item.total_less_than_48_hours);
                            const between48And72HoursPercentage = calculatePercentage(item
                                .total_between_48_and_72_hours);
                            const between72And96HoursPercentage = calculatePercentage(item
                                .total_between_72_and_96_hours);
                            const greaterThan96HoursPercentage = calculatePercentage(item
                                .total_greater_than_96_hours);

                            let tooltipContent = `
                    <div style="padding:5px">
                        <strong>${item.year}-${monthNames[item.month - 1]}</strong><br>`;

                            // Only add percentage details for categories that have data
                            if (item.total_pending > 0) {
                                tooltipContent += `Pending: ${item.total_pending} (${pendingPercentage}%)<br>`;
                            }
                            if (item.total_less_than_48_hours > 0) {
                                tooltipContent +=
                                    `< 48 hours: ${item.total_less_than_48_hours} (${lessThan48HoursPercentage}%)<br>`;
                            }
                            if (item.total_between_48_and_72_hours > 0) {
                                tooltipContent +=
                                    `48 - 72 hours: ${item.total_between_48_and_72_hours} (${between48And72HoursPercentage}%)<br>`;
                            }
                            if (item.total_between_72_and_96_hours > 0) {
                                tooltipContent +=
                                    `72 - 96 hours: ${item.total_between_72_and_96_hours} (${between72And96HoursPercentage}%)<br>`;
                            }
                            if (item.total_greater_than_96_hours > 0) {
                                tooltipContent +=
                                    `> 96 hours: ${item.total_greater_than_96_hours} (${greaterThan96HoursPercentage}%)`;
                            }

                            tooltipContent += `</div>`;

                            chartData.push([
                                `${item.year}-${monthNames[item.month - 1]}`,
                                item.total_pending,
                                item.total_less_than_48_hours,
                                item.total_between_48_and_72_hours,
                                item.total_between_72_and_96_hours,
                                item.total_greater_than_96_hours || 0, // Ensure zero is passed if no data
                                tooltipContent
                            ]);
                        });

                        const dataTable = google.visualization.arrayToDataTable(chartData);

                        const currentYear = new Date().getFullYear();

                        const options = {
                            title: `All Branch - ${currentYear} - MONTHLY STATUS WISE RESULT`,
                            hAxis: {
                                title: 'Year-Month'
                            },
                            vAxis: {
                                title: 'Count'
                            },
                            legend: {
                                position: 'top',
                                maxLines: 3
                            },
                            bar: {
                                groupWidth: '75%'
                            },
                            isStacked: true,
                            colors: ['#570987', '#109618', '#FFA500', '#DC4D01',
                            '#800000'], // purple, Green, yellow, Orange, Maroon
                            tooltip: {
                                isHtml: true
                            }
                        };

                        const chart = new google.visualization.ColumnChart(document.getElementById('repairtime_chart'));
                        chart.draw(dataTable, options);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
            
        </script>
    @endpush
@endsection

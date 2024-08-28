@extends('Admin/layout')
@section('page_title', 'Makita Admin | Dashboard')
@section('dashboard_select', 'active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- iCheck -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
            <!-- JQVMap -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/jqvmap/jqvmap.min.css') }}">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/daterangepicker/daterangepicker.css') }}">
            <!-- summernote -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.css') }}">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet"
                href="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        @endpush
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @if (session()->has('msg'))
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">{{ session('msg') }}</h3>
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
                        <h1 class="m-0">Dashboard</h1>
                        @role('admin1126906841', 'super-admin1944305928')
                            Super Admin Role
                        @endrole
                        @permission('edit565288565', 'delete1300606601', 'view1234209540')
                            Super Admin Permission
                        @endpermission
                        @module('modules2087432049')
                            Super Admin Module
                        @endmodule
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>44</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>65</h3>

                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Sales
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab"
                                                id="ysc">Year</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#sales-chart" data-toggle="tab"
                                                id="csc">Category</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active yscd" id="revenue-chart"
                                    style="position: relative; height: 500px;">
                                    <div id="line_chart" style="width: 100%; height: 500px;"></div>
                                </div>
                                <div class="chart tab-pane cdcd" style="position: relative; height: 0px; ">
                                    <div id="category_chart" style="width: 100%; height: 500px;opacity:0" class="cdc">
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">
                        <!-- Map card -->
                        <div class="card bg-gradient-primary">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Sales Chart By States: April 2023-March 2024
                                </h3>
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                        <i class="far fa-calendar-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div id="chart_div" style="height: 500px; width: 100%;"></div>
                            <!-- /.card-body-->
                            <div class="card-footer bg-transparent" style="display: none">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div id="sparkline-1"></div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-2"></div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-3"></div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- right col -->
                </div>
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-9 connectedSortable">

                        @role('admin1126906841', 'super-admin1944305928')
                            <!-- TABLE: LATEST ORDERS -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Employee Login Activity</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Emp Code</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Last Seen</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($empLoginActivity as $key => $empLoginActivityData)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td><a href="{{ url('admin/employee/manage-employee/') }}/{{ Crypt::encrypt($empLoginActivityData->employee_slug) }}"
                                                                title="Edit">
                                                                MIN-{{ $empLoginActivityData->employee->employee_no }}</a>
                                                        </td>
                                                        <td>{{ $empLoginActivityData->employee->full_name }}
                                                        </td>
                                                        <td>{{ $empLoginActivityData->employee->phone_number }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($empLoginActivityData->last_activity)->diffForHumans() }}
                                                        </td>
                                                        <td>
                                                            @if (Cache::has('emp-login-activity' . $empLoginActivityData->id))
                                                                <span class="badge badge-success">On-line</span>
                                                            @else
                                                                <span class="badge badge-danger">Off-line</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endrole

                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('admin_assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- ChartJS -->
        <script src="{{ asset('admin_assets/plugins/chart.js/Chart.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('admin_assets/plugins/sparklines/sparkline.js') }}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('admin_assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('admin_assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('admin_assets/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>

        <!-- overlayScrollbars -->
        <script src="{{ asset('admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset('admin_assets/js/pages/dashboard.js') }}"></script>

        <script>
            $(function() {
                $("#ysc").click(function() {
                    $(".cdc").css({
                        "opacity": "0"
                    });
                    $(".cdcd").css({
                        "height": "0px"
                    });
                    $(".yscd").css({
                        "height": "500px"
                    });
                });
                $("#csc").click(function() {
                    $(".cdc").css({
                        "opacity": "1"
                    });
                    $(".cdcd").css({
                        "height": "500px"
                    });
                    $(".yscd").css({
                        "height": "0px"
                    });
                });
            });
        </script>





        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load the Visualization API and the geochart package.
            google.charts.load('current', {
                'packages': ['geochart'],
                // Note: You don't need to specify a callback to draw the chart since we're using the ready event below.
            });

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                // Define the data as an array of arrays.
                var data = google.visualization.arrayToDataTable([
                    ['State', 'Total Sales'],
                    ['Andhra Pradesh', 11062936],
                    ['Arunachal Pradesh', null],
                    ['Assam', 47873707],
                    ['Bihar', 16976932],
                    ['Chhattisgarh', 22230455],
                    ['IN-DL', 125454122],
                    ['Goa', 12785698],
                    ['Gujarat', 286276041],
                    ['Haryana', 37628950],
                    ['Himachal Pradesh', null],
                    ['Jammu and Kashmir', null],
                    ['Jharkhand', 20405145],
                    ['Karnataka', 186627719],
                    ['Kerala', 193508025],
                    ['Madhya Pradesh', 53005030],
                    ['Maharashtra', 234895465],
                    ['Manipur', null],
                    ['Meghalaya', null],
                    ['Mizoram', null],
                    ['Nagaland', null],
                    ['Orissa', 21923080],
                    ['Punjab', 57490142],
                    ['Rajasthan', 96934682],
                    ['Sikkim', null],
                    ['Tamil Nadu', 279953576],
                    ['Telangana', 95933954],
                    ['Tripura', null],
                    ['Uttar Pradesh', 72870168],
                    ['IN-UT', 34491647],
                    ['West Bengal', 138852922]
                ]);

                // Set chart options
                var options = {
                    region: 'IN', // ISO 3166-1 alpha-2 country code for India
                    resolution: 'provinces', // Display state-level data
                    colorAxis: {
                        colors: ['#008F9E', '#FF6347', '#FFA500', '#FFD700']
                    }, // Custom color scale starting from red #FF0000
                    backgroundColor: '#238eff', // Background color for the chart
                    datalessRegionColor: '#238eff', // Color for regions with no data
                    defaultColor: '#f5f5f5', // Default color for regions
                    tooltip: {
                        textStyle: {
                            color: '#444444',
                            fontName: 'Arial',
                            fontSize: 12
                        }
                    }
                };

                // Instantiate and draw the chart.
                var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {
                'packages': ['corechart']
            });

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Month');
                data.addColumn('number', 'Year 2021');
                data.addColumn('number', 'Year 2022');
                data.addColumn('number', 'Year 2023');
                data.addColumn('number', 'Year 2024');

                // Add data rows for each month and year (sample data)
                data.addRows([
                    ['Jan', 164349941, 204046805, 201440934, 275645765],
                    ['Feb', 178005065, 208585087, 194605052, 130473971],
                    ['Mar', 228300617, 281154704, 257504924, 163359932],
                    ['Apr', 90288611, 170586458, 147367262, null],
                    ['May', 27801489, 192476670, 160344043, null],
                    ['Jun', 144944569, 213809189, 161223615, null],
                    ['Jul', 236338957, 243052068, 211286845, null],
                    ['Aug', 240071275, 204158301, 200836652, null],
                    ['Sep', 253394740, 290084000, 213257875, null],
                    ['Oct', 228165909, 136939759, 159157431, null],
                    ['Nov', 181798783, 170075872, 133757097, null],
                    ['Dec', 187230789, 197108332, 161099387, null],
                ]);

                // Set chart options
                var options = {
                    title: 'Sales Data for Last 3 Financial Years',
                    curveType: 'function',
                    legend: {
                        position: 'top'
                    },
                    hAxis: {
                        title: 'Month'
                    },
                    vAxis: {
                        title: 'Sales'
                    }
                };

                // Instantiate and draw the chart.
                var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {
                'packages': ['corechart']
            });

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Product');
                data.addColumn('number', 'Total Sales');
                data.addRows([
                    ['ACC', 511875766.42],
                    ['SPARE', 257679265.84],
                    ['TOOL', 1348254848.98]
                ]);

                // Set chart options
                var options = {
                    title: 'Sales by Category: April 2023 - March 2024',
                    pieHole: 0.4, // Size of the donut hole (0 to 1, 0 for full pie chart)
                    colors: ['#FDB515', '#E91E63', '#03A9F4'], // Custom colors for the chart slices
                    legend: {
                        position: 'bottom'
                    }
                };

                // Instantiate and draw the chart.
                var chart = new google.visualization.PieChart(document.getElementById('category_chart'));
                chart.draw(data, options);
            }
        </script>
    @endpush
@endsection

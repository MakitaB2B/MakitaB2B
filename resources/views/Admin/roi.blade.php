@extends('Admin/layout')
@section('page_title', 'ROI List | MAKITA')
@section('tools_roi', 'active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- DataTables -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet"
                href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <style>
                .margin5px {
                    margin-left: 5px !important;
                }

                .minbtn {
                    background-color: #008290 !important;
                    border-color: #00e6ff !important;
                    cursor: unset !important;
                }

                .minbgcolor {
                    background-color: #008290 !important;
                }

                .minbordertop {
                    border-top: 3px solid #008290 !important;
                }

                .txtcolor {
                    color: #008290 !important;
                }

                .comptitle {
                    color: #008290 !important;
                    font-size: 20px !important;
                }

                .compsubtitle {
                    color: #044c54 !important;
                    font-size: 15px !important;
                }

                .atagprice {
                    color: #008290 !important;
                    font-weight: 600 !important;
                }

                .nav-pills .nav-link.active,
                .nav-pills .show>.nav-link {
                    color: #fff !important;
                    background-color: #008290;
                }

                .cmptblhdr {
                    background-color: #008290 !important;
                    color: #fff !important;
                }
            </style>
        @endpush


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Out Door Power Equipment(OPE)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">ROI</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline minbordertop">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('admin_assets/img/roi/UR012G.png') }}" alt="OPE TOOLS">
                                </div>

                                <h3 class="profile-username text-center">Cordless Brush Cutter</h3>

                                <p class="text-muted text-center">Total Expense 1 Year</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Total Cost</b> <a class="float-right atagprice">&#8377;85,521</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Battery Consumption</b> <a class="float-right atagprice">&#8377;6,912</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>General Expenses</b> <a class="float-right atagprice">&#8377;0</a>
                                    </li>
                                </ul>

                                <a href="javascript:void(0);" class="btn btn-primary btn-block minbtn"><b>Total Cost =
                                        &#8377;92,433</b></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header minbgcolor">
                                <h3 class="card-title">Advantages of Cordless Brush Cutter</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-play mr-1"></i> Easy Start</strong>

                                <p class="text-muted">
                                    Easy Start Compared to Gasoline type. by just pressing a button Cordless Tools get
                                    switched on.
                                </p>

                                <hr>

                                <strong><i class="fas fa-times mr-1"></i> No Pollution</strong>

                                <p class="text-muted">Pollution free as it is a Brushless Motor.</p>

                                <hr>

                                <strong><i class="fas fa-bell-slash mr-1"></i> Less Noise</strong>

                                <p class="text-muted">Compared to Gasoline type Cordless produce less Noise.</p>

                                <hr>

                                <strong><i class="far fa fa-exclamation-circle mr-1"></i> Less Expense</strong>

                                <p class="text-muted">As like Gasoline Type Cordless doesn’t need fuel. where Gasoline type
                                    spend almost 75% of their total expense in Fuel for a year and for Cordless only 8% of
                                    their total expense is spent for Charging the battery.</p>
                                <hr>

                                <strong><i class="far fa fa-heartbeat mr-1"></i> Invest & Enjoy</strong>

                                <p class="text-muted">Cordless Tools are one time Investment .</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active navlinkminclr" href="#activity"
                                            data-toggle="tab">Comparison</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Feedback</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                         <!-- Post -->
                                         <div class="post clearfix">
                                            <div class="user-block">
                                                <span class="username margin5px">
                                                    <a href="#" class="comptitle">Total Expense</a>
                                                    <a href="#" class="float-right btn-tool"><i
                                                            class="fas fa-times"></i></a>
                                                </span>
                                                <span class="description margin5px compsubtitle">Total Expense for 1
                                                    Year</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="card card-widget widget-user">
                                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                                        <div class="widget-user-header bg-danger">
                                                            <h3 class="widget-user-username">Petrol Brush Cutter</h3>
                                                            <h5 class="widget-user-desc">Total Cost &#8377;2,19,676.00</h5>
                                                        </div>
                                                        <div class="widget-user-image">
                                                            <img class="img-circle elevation-2"
                                                                src="{{ asset('admin_assets/img/roi/petrolbrushcutter.jpg') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row">
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;32,000.00
                                                                        </h5>
                                                                        <span class="description-text">Tool Cost</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;1,77,984
                                                                        </h5>
                                                                        <span class="description-text">Fuel
                                                                            Consumption</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;9,692</h5>
                                                                        <span class="description-text">General
                                                                            Expenses</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <div class="col-6">
                                                    <div class="card card-widget widget-user">
                                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                                        <div class="widget-user-header bg-success minbgcolor">
                                                            <h3 class="widget-user-username">Cordless Brush Cutter</h3>
                                                            <h5 class="widget-user-desc">Total Cost &#8377;92,433.00</h5>
                                                        </div>
                                                        <div class="widget-user-image">
                                                            <img class="img-circle elevation-2"
                                                                src="{{ asset('admin_assets/img/roi/cordlessbrushcutter.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row">
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;85,521.00
                                                                        </h5>
                                                                        <span class="description-text">Tool Cost</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;6,912.00
                                                                        </h5>
                                                                        <span class="description-text">Battery Usage</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-4">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">&#8377;0</h5>
                                                                        <span class="description-text">General
                                                                            Expenses</span>
                                                                    </div>
                                                                    <!-- /.description-block -->
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                        </div>
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="linechart"></div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username margin5px">
                                                    <a href="#" class="comptitle">Petrol Vs Cordless Brush Cutter</a>
                                                    <a href="#" class="float-right btn-tool"><i
                                                            class="fas fa-times"></i></a>
                                                </span>
                                                <span class="description margin5px compsubtitle">The winner is Cordless
                                                    Brush</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Petrol Brush cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Model</th>
                                                                        <th>RBC411U</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Type of Engine/CC</td>
                                                                        <td>2stroke/40.2cc</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Type of Fuel</td>
                                                                        <td>Petrol</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Type of application</td>
                                                                        <td>Professional work for 5 to 6 hours daily</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Engine Speed</td>
                                                                        <td>10,000rpm</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Fuel Tank Capacity</td>
                                                                        <td>1.1ltr</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Weight</td>
                                                                        <td>7.3kg</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Cordless Brush Cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Model</th>
                                                                        <th>UR006GZ02 + Power Source Kit</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Type of Motor</td>
                                                                        <td>Brushless Motor</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Voltage</td>
                                                                        <td>40V max</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Type of application</td>
                                                                        <td>Battery backup 30 to 45min</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Engine Speed</td>
                                                                        <td>5,500 rpm</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Weight</td>
                                                                        <td>6.2kg</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <span class="username margin5px">
                                                    <a href="#" class="comptitle">Petrol and Electricity Consumption
                                                        Chart</a>
                                                    <a href="#" class="float-right btn-tool"><i
                                                            class="fas fa-times"></i></a>
                                                </span>
                                                <span class="description margin5px compsubtitle">Petrol Vs Cordless Brush
                                                    Cutter</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Petrol Brush cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Duration</th>
                                                                        <th>Petrol Consumption</th>
                                                                        <th>Ltr*Price</th>
                                                                        <th>Total Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>1 hour</td>
                                                                        <td>1 ltr</td>
                                                                        <td>1*103</td>
                                                                        <td>103</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Day</td>
                                                                        <td>6 ltr</td>
                                                                        <td>6*103</td>
                                                                        <td>618</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Week</td>
                                                                        <td>36 ltr</td>
                                                                        <td>36*103</td>
                                                                        <td>3,708.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Month</td>
                                                                        <td>144 ltr</td>
                                                                        <td>144*103</td>
                                                                        <td>14,832.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>6 Month</td>
                                                                        <td>864 ltr</td>
                                                                        <td>864*103</td>
                                                                        <td>88,992.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>12 Month</td>
                                                                        <td>1728 ltr</td>
                                                                        <td>17281*103</td>
                                                                        <td>1,77,984.00</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Cordless Brush Cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Duration</th>
                                                                        <th>Electricity Consumption</th>
                                                                        <th>Unit*Price</th>
                                                                        <th>Total Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>2 hour</td>
                                                                        <td>1 unit</td>
                                                                        <td>1*8</td>
                                                                        <td>8</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Day</td>
                                                                        <td>3 unit</td>
                                                                        <td>3*8</td>
                                                                        <td>24</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Week</td>
                                                                        <td>18 unit</td>
                                                                        <td>18*8</td>
                                                                        <td>144</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>1 Month</td>
                                                                        <td>72 unit</td>
                                                                        <td>72*8</td>
                                                                        <td>576</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>6 Month</td>
                                                                        <td>432 unit</td>
                                                                        <td>432*8</td>
                                                                        <td>3,456.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>12 Month</td>
                                                                        <td>864 unit</td>
                                                                        <td>864*8</td>
                                                                        <td>6,912.00</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->
                                        <!-- Post -->
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <span class="username margin5px">
                                                    <a href="#" class="comptitle">Engine Service Chart for a
                                                        Year</a>
                                                    <a href="#" class="float-right btn-tool"><i
                                                            class="fas fa-times"></i></a>
                                                </span>
                                                <span class="description margin5px compsubtitle">Petrol Vs Cordless Brush
                                                    Cutter</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Petrol Brush cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-hover text-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Image</th>
                                                                        <th>Description</th>
                                                                        <th>Replacement Period</th>
                                                                        <th>Qty</th>
                                                                        <th>Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Clutch Shoe</td>
                                                                        <td>Quarterly once</td>
                                                                        <td>4</td>
                                                                        <td>1313</td>
                                                                        <td>5,252.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Clutch drum</td>
                                                                        <td>Quarterly once</td>
                                                                        <td>4</td>
                                                                        <td>557</td>
                                                                        <td>2,228.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Clutch Spring</td>
                                                                        <td>Quarterly once</td>
                                                                        <td>4</td>
                                                                        <td>103</td>
                                                                        <td>4,12.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Gasket</td>
                                                                        <td>Quarterly once</td>
                                                                        <td>4</td>
                                                                        <td>200</td>
                                                                        <td>800</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Carburetor</td>
                                                                        <td>Six Month once have to be Serviced</td>
                                                                        <td>4</td>
                                                                        <td>500</td>
                                                                        <td>1,000.00</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                                <div class="col-4">
                                                    <div class="card">
                                                        <div class="card-header cmptblhdr">
                                                            <h3 class="card-title">Cordless Brush Cutter</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body table-responsive p-0">
                                                            <div class="attachment-block clearfix">
                                                                <img class="attachment-img"
                                                                    src="{{ asset('admin_assets/img/roi/BL-05.png') }}"
                                                                    alt="Attachment Image">

                                                                <div class="attachment-pushed">
                                                                    <h4 class="attachment-heading"><a href="#">Less
                                                                            Maintenance</a></h4>

                                                                    <div class="attachment-text">
                                                                        Less Maintenance for Cordless OPE Tools as it is
                                                                        Direct Current Brushless Motor
                                                                    </div>
                                                                    <!-- /.attachment-text -->
                                                                </div>
                                                                <!-- /.attachment-pushed -->
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post -->

                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username margin5px">
                                                    <a href="#" class="comptitle">Thank You</a>
                                                    <a href="#" class="float-right btn-tool"><i
                                                            class="fas fa-times"></i></a>
                                                </span>
                                                <span class="description margin5px compsubtitle">PREPARED BY : KARTHICK M
                                                    P</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <img class="img-fluid"
                                                        src="{{ asset('admin_assets/img/roi/backdrop.jpg') }}"
                                                        alt="Photo">
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <img class="img-fluid mb-3"
                                                                src="{{ asset('admin_assets/img/roi/backdrop-1.jpg') }}"
                                                                alt="Photo">
                                                            <img class="img-fluid"
                                                                src="{{ asset('admin_assets/img/roi/backdrop-3.jpg') }}"
                                                                alt="Photo">
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-sm-6">
                                                            <img class="img-fluid mb-3"
                                                                src="{{ asset('admin_assets/img/roi/backdrop-4.jpg') }}"
                                                                alt="Photo">
                                                            <img class="img-fluid"
                                                                src="{{ asset('admin_assets/img/roi/backdrop-2.jpg') }}"
                                                                alt="Photo">
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.post -->
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="settings">
                                        <form class="form-horizontal">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Customer
                                                    Name</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputName"
                                                        placeholder="Enter Customer Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Customer
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        placeholder="Enter Customer Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Customer
                                                    Phone</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputName2"
                                                        placeholder="Enter Customer Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Customer
                                                    Location</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputSkills"
                                                        placeholder="Enter Customer Location">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputExperience"
                                                    class="col-sm-2 col-form-label">Experience</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> I agree to the <a href="#">terms
                                                                and conditions</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Expense Type', 'Cordless Brush Cutter', 'Petrol Brush Cutter'],
                    ['Tool cost', 85521, 32000],
                    ['Fuel/Battery Consumption', 6912, 177984],
                    ['General Expenses', 0, 9692],
                    ['Total Cost', 92433, 219676]
                ]);

                var options = {
                    title: '',
                    curveType: 'function',
                    legend: {
                        position: 'top'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('linechart'));

                chart.draw(data, options);
            }
        </script>
    @endpush
@endsection

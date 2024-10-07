@extends('Admin/layout')
@section('page_title', 'Business Trips | MAKITA')
@section('travelmanagement-expandable', 'menu-open')
@section('travelmanagement-expandable', 'active')
@section('business-trips-select', 'active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- DataTables -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <!-- Date and time picker -->
            <link rel="stylesheet"
                href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
            <link rel="stylesheet"
            href="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

            <style>
                .btcardbs {
                    box-shadow: rgb(178 180 181) 0px 4px 9px 2px;
                }

                .bg-makita-til {
                    background-color: #008290 !important;
                }

                .bg-makita-black {
                    background-color: #4b4c4e !important;
                }

                .color-white {
                    color: rgb(255, 255, 255);
                }

                .info-box-number {
                    font-size: 19px !important;
                    font-weight: 600 !important;
                }

                .cursorpointer {
                    cursor: pointer;
                }

                .btn-primary {
                    background-color: #008290 !important;
                    border-color: #0ac8dd !important;
                }

                .dacss {
                    background: cadetblue;
                    padding: 5px;
                    border-radius: 3px;
                    color: snow;
                    font-size: 17px;
                }

                .dcentcss {
                    background: linear-gradient(45deg, #004148, transparent);
                    padding: 5px;
                    border-radius: 3px;
                    color: #ffffff;
                    font-size: 17px;
                }

                .modelheadercss {
                    background: #008290;
                }

                .modelheadercontent {
                    color: #ffffff;
                    font-weight: 600;
                }

                .colorwhite {
                    color: #ffffff;
                }

                .fvegbt {
                    display: none;
                }

                .dpnone {
                    display: none !important;
                }
                .mw900px{
                    max-width: 900px !important;
                }
                .modelbs{
                    box-shadow: 0 0.5rem 1rem rgb(0 65 72) !important;
                }
            </style>
        @endpush

        <!-- The BTA Application Modal -->
        <div class="modal" id="btaModal">
            <div class="modal-dialog mw900px">
                <div class="modal-content modelbs">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Apply For A New Business Trip Advanced</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="POST" action="{{ route('travelmanagement.create-travel-management-applications') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                <label for="exampleSDT">Starting Date & Time*</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" name="starting_date_time"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime"
                                        required />
                                    <div class="input-group-append" data-target="#reservationdatetime"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputCostEstimation">Ending Date & Time*</label>
                                    <div class="input-group date" id="reservationdatetimeid" data-target-input="nearest">
                                    <input type="text" name="bta_ending_datetime"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetimeid"
                                        required />
                                    <div class="input-group-append" data-target="#reservationdatetimeid"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Number of days*</label>
                                    <input type="text" class="form-control" name="total_trip_days" required
                                        id="exampleInputCostEstimation" placeholder="Enter Number of days">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputCostEstimation">Place of Visit*</label>
                                    <input type="text" class="form-control" name="bta_place_of_visit" required
                                        id="exampleInputCostEstimation" placeholder="Enter Place of Visit">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleServiceCost">Purpose of Visit*</label>
                                    <input type="text" class="form-control" name="purpose_of_visit" required
                                        id="exampleInputCostEstimation" placeholder="Enter Purpose of Visit">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="gbt" id="gbdv">
                                        <label for="itgbdv">
                                            Is it Group BT/ DEMO Vehicle?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 fvegbt">
                                    <label for="exampleInputCostEstimation">Vehicle Type*</label>
                                    <select class="custom-select form-control-border" id="btavt" name="vechile_type">
                                        <option value="">Select Type</option>
                                        <option value="1">Company</option>
                                        <option value="2">Personal</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 fvegbt">
                                    <label for="exampleInputCostEstimation" class="btavtl" style="display: none">Vehicle
                                        Number*</label>
                                    <input type="text" class="form-control btapvn" name="cost_estimation"
                                        placeholder="Vehicle Number" style="display: none"  name="own_vechile_number">

                                    <select class="custom-select form-control-border btacvn" style="display: none" name="company_vechile_number">
                                        <option value="">Select Vehicle Number</option>
                                        <option value="KA03TA9859">KA03TA9859</option>
                                        <option value="KA06AL6254">KA06AL6254</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 fvegbt">
                                    <label for="exampleInputCostEstimation">Fuel Expenses*</label>
                                    <input type="text" class="form-control" name="fuel_expenses"
                                        placeholder="Fuel Expenses">
                                </div>
                                <div class="form-group col-md-4 fvegbt">
                                    <label for="exampleInputCostEstimation">Employee(S)*</label>
                                    <select class="custom-select form-control-border" name="groupbt_employees">
                                        <option value="">Select Employee</option>
                                        <option value="">Shankhadip Bal</option>
                                        <option value="">Jean lobo</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row" id="previouscompany_doc_box">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Date*</label>
                                    <input type="date" class="form-control" name="bta_expbreakup_date[]" required
                                        id="exampleInputCostEstimation">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Place of Visit*</label>
                                    <input type="text" class="form-control" name="trip_place_of_visit[]" required
                                        id="exampleInputCostEstimation" placeholder="Enter Place of Visit">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Journey Fare*</label>
                                    <input type="text" class="form-control" name="journey_fare[]" required
                                        id="exampleInputCostEstimation" placeholder="Enter Journey Fare">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Accommodation*</label>
                                    <input type="text" class="form-control" name="accommodation[]" required
                                        id="exampleInputCostEstimation" placeholder="Enter Accommodation">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Conveyance*</label>
                                    <input type="text" class="form-control" name="conveyance[]" required
                                        id="exampleInputCostEstimation" placeholder="Enter Conveyance">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleServiceCost">Amount (Rs)*</label>
                                    <input type="text" class="form-control" name="amount[]" required
                                        id="exampleInputCostEstimation" placeholder="Amount">
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 30px;">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <button type="button" class="btn btn-success" onclick="add_more()">Add More
                                                +</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- The BTC Application Modal -->
        <div class="modal" id="btcModal">
            <div class="modal-dialog mw900px">
                <div class="modal-content modelbs">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Apply For A New Business Trip Claim</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="POST" action="{{ route('service-management.send-service-cost-estimation-cx') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Starting Date & Time*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Starting Date & Time">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputCostEstimation">Ending Date & Time*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Ending Date & Time">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Number of days*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Number of days">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputCostEstimation">Place of Visit*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Place of Visit">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleServiceCost">Purpose of Visit*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Purpose of Visit">
                                </div>
                            </div>
                            <hr>
                            <div class="row" id="btc_expenses">
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Date*</label>
                                    <input type="date" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Amount*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enter Amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Enclosure No*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        id="exampleInputCostEstimation" placeholder="Enclosure No">
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="exampleServiceCost">Description*</label>
                                    <select class="custom-select form-control-border">
                                        <option>Select One</option>
                                        <option>Travelling Exp Local</option>
                                        <option>Boarding & Lodging Exp Local</option>
                                        <option>Communication & Telephone Exo</option>
                                        <option>Courier Exp</option>
                                        <option>Printing & Stationery Exp</option>
                                        <option>Computer Maintenance Exp</option>
                                        <option>Electricity & water charges Exp</option>
                                        <option>Freight Charges-Local Exp</option>
                                        <option>Vehicle maintenance Other than Fuel Exp</option>
                                        <option>Fuel Exp</option>
                                        <option>Food Exp</option>
                                        <option>Service Room maintenance Exp</option>
                                        <option>Off Maintenance Exp</option>
                                        <option>Office Expenses</option>
                                        <option>Travelling Overseas</option>
                                        <option>Boarding Overseas</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Receipt Image*</label>
                                    <input type="file" name="cost_estimation" required>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 30px;">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <button type="button" class="btn btn-success"
                                                onclick="add_more_btcexpenses()">Add More +</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4 class="dacss">Dearness Allowance / Food Allowance Details</h4>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">From Date*</label>
                                    <input type="date" class="form-control" name="cost_estimation" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">To Date*</label>
                                    <input type="date" class="form-control" name="cost_estimation" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">No. Of Days*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="No. Of Days">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Eligible DA/FA Day*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Eligible DA/FA Day">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Amount*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Enter Amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Enclosure No*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Enclosure No">
                                </div>
                            </div>
                            <hr>
                            <h5 class="dcentcss">Dealer or Customer Entertainment Expenses / Porter Charge</h5>
                            <div class="row" id="btc_entexpns">
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Date*</label>
                                    <input type="date" class="form-control" name="cost_estimation" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Descriptions*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Descriptions">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Amount*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Enter Amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Enclosure No*</label>
                                    <input type="text" class="form-control" name="cost_estimation" required
                                        placeholder="Enclosure No">
                                </div>
                                <div class="form-group col-md-4" style="margin-top: 30px;">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <button type="button" class="btn btn-success"
                                                onclick="add_more_entertainmentexp()">Add More +</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Apply</button>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- The LTC Application Modal -->
        <div class="modal" id="ltcModal">
            <div class="modal-dialog mw900px">
                <div class="modal-content modelbs">

                    <!-- Modal Header -->
                    <div class="modal-header modelheadercss">
                        <h6 class="modal-title modelheadercontent">Apply For A New Local Travel Claim</h6>
                        <button type="button" class="close colorwhite" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="POST" action="{{ route('travelmanagement.create-ltc-claim-application') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">LTC for the Month*</label>
                                    <select class="custom-select form-control-border" name=ltc_month>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">LTC for the Year*</label>
                                    <select class="custom-select form-control-border" name=ltc_year>
                                        <option>2024</option>
                                        <option>2025</option>
                                        <option>2026</option>
                                        <option>2027</option>
                                        <option>2028</option>
                                        <option>2029</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row" id="ltc_expenses">
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Date*</label>
                                    <input type="date" class="form-control" name="date[]" required
                                        id="exampleInputCostEstimation">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Mode of Transport*</label>
                                    <input type="text" class="form-control" name="mode_of_transport[]" required
                                        id="exampleInputCostEstimation" placeholder="Mode of Transport">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Opening Meter*</label>
                                    <input type="text" class="form-control" name="opening_meter[]" required
                                        id="exampleInputCostEstimation" placeholder="Opening Meter">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Closing Meter*</label>
                                    <input type="text" class="form-control" name="closing_meter[]" required
                                        id="exampleInputCostEstimation" placeholder="Closing Meter">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Total KM*</label>
                                    <input type="text" class="form-control" name="total_km[]" required
                                        id="exampleInputCostEstimation" placeholder="Enter Total KM">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Places Visited*</label>
                                    <input type="text" class="form-control" name="place_visited[]" required
                                        placeholder="Enter Places Visited">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Claim Amount*</label>
                                    <input type="text" class="form-control" name="claim_amount[]" required
                                        placeholder="Enter Claim Amount">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Lunch Exp.*</label>
                                    <input type="text" class="form-control" name="lunch_exp[]" required
                                        placeholder="Enter Lunch Exp.">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Fuel Expenses*</label>
                                    <input type="text" class="form-control" name="fuel_exp[]" required
                                        placeholder="Fuel Expenses">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleServiceCost">Toll Charges*</label>
                                    <input type="text" class="form-control" name="toll_charge[]" required
                                        placeholder="Toll Charges">
                                </div>
                                <div class="form-group col-md-4" style="margin-top: 30px;">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <button type="button" class="btn btn-success"
                                                onclick="add_more_ltcexpenses()">Add More +</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="dcentcss">Miscellaneous Expenses</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Courier Bill*</label>
                                    <input type="text" class="form-control" name="courier_bill" required
                                        placeholder="Monthly Courier Bill">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Xerox & Stationary*</label>
                                    <input type="text" class="form-control" name="xerox_stationary" required
                                        placeholder="Xerox & Stationary">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Office Expenses*</label>
                                    <input type="text" class="form-control" name="office_expense" required
                                        placeholder="Enter Office Expenses">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleServiceCost">Monthly Mobile Bills*</label>
                                    <input type="text" class="form-control" name="monthly_mobile_bill" required
                                        placeholder="Enter Mobile Bills">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleServiceCost">Remark, If Any</label>
                                    <textarea class="form-control" name="remarks" rows="2" placeholder="Enter Remark, If Any"
                                        required=""></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="col-md-3 col-sm-3 col-12 cursorpointer" data-toggle="modal" data-target="#btaModal">
                        <div class="info-box bg-makita-til btcardbs">
                            <span class="info-box-icon"><i class="far fa fa-plane color-white"></i></span>

                            <div class="info-box-content color-white">
                                <span class="info-box-number">BTA (Business Trip Advanced)</span>
                                <span class="info-box-text">Total Trip: 10</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    Apply BTA
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-3 col-12 cursorpointer" data-toggle="modal" data-target="#btcModal">
                        <div class="info-box bg-makita-black btcardbs">
                            <span class="info-box-icon"><i class="far fa fa-car color-white"></i></span>

                            <div class="info-box-content color-white">
                                <span class="info-box-number">BTC (Business Trip Claim)</span>
                                <span class="info-box-text">Total Trip: 41</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    Apply BTC
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12 cursorpointer" data-toggle="modal" data-target="#ltcModal">
                        <div class="info-box bg-makita-til btcardbs">
                            <span class="info-box-icon"><i class="far fa fa-motorcycle color-white"></i></span>

                            <div class="info-box-content color-white">
                                <span class="info-box-number">LTC (Local Travel Claim)</span>
                                <span class="info-box-text">Total Trip: 5</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    Apply LTC
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Business Trips</li>
                        </ol>
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
                                <h3 class="card-title">Bussiness Trips</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Starting Date & Time</th>
                                            <th>Ending Date & Time</th>
                                            <th>Trip Name </th>
                                            <th>Total Expenses</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($holidayList as $key => $list)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $list->name }}</td>
                    <td>{{ $list->from_date }}</td>
                    <td>{{ $list->to_date }}</td>
                    <td>{{ $list->holidayType->pluck('name')->implode('') }}</td>
                    <td>
                        @if ($list->state == 56)
                        {{"All States"}}
                        @else
                        {{ $list->stateData->pluck('name')->implode('') }}
                        @endif
                    </td>
                    <td>{{ $list->notes }}</td>
                    <td><a href="{{ url('admin/holidays/manage-holiday')}}/{{ Crypt::encrypt($list->slug) }}" title="Edit"> <i class="nav-icon fas fa-edit"></i></a></td>
                  </tr>
                  @endforeach --}}

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Starting Date & Time</th>
                                            <th>Ending Date & Time</th>
                                            <th>Trip Name </th>
                                            <th>Total Expenses</th>
                                            <th>Status</th>
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

     <!-- Date and time picker -->
    <!-- InputMask -->
    <script src="{{ asset('admin_assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

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
            // BTA
            var loop_count = 1;

            function add_more() {
                loop_count++;
                var html = '<input name="ewe_slug" type="hidden"><div class="row" id="prevcom_docs_' + loop_count +
                    '" style="margin-top:20px">';
                html +=
                    '<div class="form-group col-md-6"> <label for="exampleBTADtlDate">Date*</label>  <input type="date" class="form-control" name="bta_expbreakup_date[]" required value="" id="exampleCompanyName" ></div>';
                html +=
                    '<div class="form-group col-md-6"> <label for="exampleInputBTADtlPlaceofVisit">Place of Visit*</label> <input type="text" class="form-control" required name="trip_place_of_visit[]" placeholder="Place of Visit"> </div>';
                html +=
                    '<div class="form-group col-md-6"> <label for="exampleInputBTADtlJFt">Journey Fare*</label> <input type="text" class="form-control" required name="journey_fare[]" placeholder="Journey Fare"> </div>';
                html +=
                    '<div class="form-group col-md-6"> <label for="exampleInputBTADtlAccomodation">Accommodation*</label> <input type="text" class="form-control" required name="accommodation[]" placeholder="Accommodation"> </div>';
                html +=
                    '<div class="form-group col-md-6"> <label for="exampleInputBTAConviniance">Conveyance*</label> <input type="text"  class="form-control" required name="conveyance[]" placeholder="Conveyance"> </div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInputAmount">Amount (Rs)*</label> <input type="text" class="form-control" required name="amount[]" placeholder="Amount"> </div>';
                html +=
                    '<div class="form-group col-md-3"><br><button type="button" class="btn btn-danger btn-lg" onclick=remove_more("' +
                    loop_count + '")>Remove</button></div>';
                html += '</div>';
                jQuery("#previouscompany_doc_box").append(html);
            }

            function remove_more(loop_count) {
                jQuery('#prevcom_docs_' + loop_count).remove();
            }

            // BTC
            function add_more_btcexpenses() {
                loop_count++;
                var html = '<input name="btc_slug[]" type="hidden"><div class="row" id="btcexpenses_record_' + loop_count +
                    '" style="margin-top:20px">';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleBTADtlDate">Date*</label>  <input type="date" class="form-control" name="date[]" required value="" id="exampleCompanyName" ></div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlPlaceofVisit">Amount*</label> <input type="text" class="form-control" required name="appointment_letter[]" placeholder="Enter Amount"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlJFt">Enclosure No*</label> <input type="text" class="form-control" required name="relieving_letter[]" placeholder="Enclosure No"> </div>';
                html += '<div class="form-group col-md-5">' +
                    '<label for="exampleInputBTADtlAccomodation">Description*</label>' +
                    '<select class="custom-select form-control-border" required name="payslip_last_month[]">' +
                    '<option>Select One</option>' +
                    '<option>Travelling Exp Local</option>' +
                    '<option>Boarding & Lodging Exp Local</option>' +
                    '<option>Communication & Telephone Exp</option>' +
                    '<option>Courier Exp</option>' +
                    '<option>Printing & Stationery Exp</option>' +
                    '<option>Computer Maintenance Exp</option>' +
                    '<option>Electricity & water charges Exp</option>' +
                    '<option>Freight Charges-Local Exp</option>' +
                    '<option>Vehicle maintenance Other than Fuel Exp</option>' +
                    '<option>Fuel Exp</option>' +
                    '<option>Food Exp</option>' +
                    '<option>Service Room maintenance Exp</option>' +
                    '<option>Off Maintenance Exp</option>' +
                    '<option>Office Expenses</option>' +
                    '<option>Travelling Overseas</option>' +
                    '<option>Boarding Overseas</option>' +
                    '</select>' +
                    '</div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputAmount">Receipt Image*</label> <input type="file" > </div>';
                html +=
                    '<div class="form-group col-md-3"><br><button type="button" class="btn btn-danger btn-lg" onclick=remove_more_btcexp("' +
                    loop_count + '")>Remove</button></div>';
                html += '</div>';
                jQuery("#btc_expenses").append(html);
            }

            function remove_more_btcexp(loop_count) {
                jQuery('#btcexpenses_record_' + loop_count).remove();
            }

            function add_more_entertainmentexp() {
                loop_count++;
                var html = '<input name="btc_slug[]" type="hidden"><div class="row" id="btcentexp_record_' + loop_count +
                    '" style="margin-top:20px">';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleBTADtlDate">Date*</label>  <input type="date" class="form-control" name="date[]" required value="" id="exampleCompanyName" ></div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlPlaceofVisit">Descriptions*</label> <input type="text" class="form-control" required name="appointment_letter[]" placeholder="Enter Descriptions"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlJFt">Amount*</label> <input type="text" class="form-control" required name="relieving_letter[]" placeholder="Enter Amount"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlAccomodation">Enclosure No*</label> <input type="text" class="form-control" required name="payslip_last_month[]" placeholder="Enter Enclosure No"> </div>';
                html +=
                    '<div class="form-group col-md-4"><br><button type="button" class="btn btn-danger btn-lg" onclick=remove_more_entexpbtn("' +
                    loop_count + '")>Remove</button></div>';
                html += '</div>';
                jQuery("#btc_entexpns").append(html);
            }

            function remove_more_entexpbtn(loop_count) {
                jQuery('#btcentexp_record_' + loop_count).remove();
            }

            // LTC
            function add_more_ltcexpenses() {
                loop_count++;
                var html = '<input name="ewe_slug[]" type="hidden"><div class="row" id="ltcexpense_' + loop_count +
                    '" style="margin-top:20px">';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleBTADtlDate">Date*</label>  <input type="date" class="form-control" name="date[]" required value="" id="exampleCompanyName" ></div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlPlaceofVisit">Mode of Transport*</label> <input type="text" class="form-control" required name="mode_of_transport[]" placeholder="Mode of Transport"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlJFt">Opening Meter*</label> <input type="text" class="form-control" required name="opening_meter[]" placeholder="Opening Meter"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTADtlAccomodation">Closing Meter*</label> <input type="text" class="form-control" required name="closing_meter[]" placeholder="Closing Meter"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTAConviniance">Total KM*</label> <input type="text"  class="form-control" required name="total_km[]" placeholder="Total KM"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputBTAConviniance">Places Visited*</label> <input type="text"  class="form-control" required name="place_visited[]" placeholder="Places Visited"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputAmount">Claim Amount*</label> <input type="text" class="form-control" required name="claim_amount" placeholder="Claim Amount"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputAmount">Lunch Exp.*</label> <input type="text" class="form-control" required name="lunch_exp" placeholder="Lunch Exp."> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputAmount">Fuel Expenses*</label> <input type="text" class="form-control" required name="fuel_exp" placeholder="Fuel Expenses"> </div>';
                html +=
                    '<div class="form-group col-md-4"> <label for="exampleInputAmount">Toll Charges*</label> <input type="text" class="form-control" required name="toll_charge" placeholder="Toll Charges"> </div>';
                html +=
                    '<div class="form-group col-md-3"><br><button type="button" class="btn btn-danger btn-lg" onclick=remove_more_ltexpenses("' +
                    loop_count + '")>Remove</button></div>';
                html += '</div>';
                jQuery("#ltc_expenses").append(html);
            }

            function remove_more_ltexpenses(loop_count) {
                jQuery('#ltcexpense_' + loop_count).remove();
            }


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

            $('#gbdv').mousedown(function() {
                if (!$(this).is(':checked')) {
                    $('.fvegbt').show(1000);
                    $(this).trigger("change");
                } else {
                    $('.fvegbt').hide(1000);
                }
            });
            $(document).ready(function() {
                $('#btavt').on('change', function() {
                    let vehicleType = $.trim($("#btavt").val());
                    if (vehicleType == '') {
                        $("#btavt").css({
                            "border": "2px solid red",
                            "color": "red"
                        });
                    }
                    if (vehicleType == 1) {
                        $('.btapvn').hide(1000);
                        $('.btavtl').show(1000);
                        $('.btacvn').show(1000);
                    }
                    if (vehicleType == 2) {
                        $('.btacvn').hide(1000);
                        $('.btavtl').show(1000);
                        $('.btapvn').show(1000);
                    }

                    // if (vehicleType != '') {
                    //     $.ajax({
                    //         url: '/admin/service-management/generate-asm-report',
                    //         type: 'post',
                    //         data: 'reportYear=' + reportYear + '&reportMonth=' + reportMonth +
                    //             '&reportServiceCenter=' + reportServiceCenter +
                    //             '&_token={{ csrf_token() }}',
                    //         success: function(result) {
                    //             $('#mswrfr').html(result);

                    //             $('#mswrbranch').html(reportSCText);
                    //             $('#mswryear').html(reportYear);
                    //             $('#mswrmontsent').show();
                    //             $('#mswrmonthval').html(reportMonthText);
                    //             console.log(result);
                    //         }
                    //     });
                    // }

                });

                //Date and time picker
                $('#reservationdatetime').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    }
                });
                $('#reservationdatetimeid').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    }
                });
            });
        </script>
    @endpush
@endsection

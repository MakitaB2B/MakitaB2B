@extends('Admin/layout')
@section('page_title', 'ROI List | MAKITA')
@section('tools_roi', 'active')
@section('container')
    <style>
        .makitabgcolor {
            background-color: #008290 !important;
        }

        .makitacard {
            background-color: #008290 !important;
            color: #ffffff !important;
            box-shadow: rgb(0 0 0) 0px 1px 10px 1px !important;
        }
        .makitacard:hover {
            cursor: pointer;
        }

        hr {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }

        .mtb20 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        label select {
            display: inline-block;
            margin-left: 10px;
        }

        .fielderromsg {
            color: #d6ff00;
        }

        .btn-outline-light {
            color: #ffffff;
            border-color: #ffffff;
        }

        .nxtbtnfaicon {
            font-size: 15px !important;
            margin-left: 5px !important;
        }
    </style>
    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">ROI Calculator</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div id="cpdiv">
                        <hr>
                        <h5 class="modal-title">Competitor Product</h5>
                        <hr>
                        <div class="row mtb20">
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Total Staffs Per Day</label>
                                <input type="text" class="form-control onlynumbers" placeholder="Enter Total Staffs Per Day"
                                    id="cptspd">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Labour Cost
                                    <select>
                                        <option value="">Daily</option>
                                        <option value="" disabled>Hourly</option>
                                        <option value="" disabled>Monthly</option>
                                    </select>
                                </label>
                                <input type="text" class="form-control onlynumbers" placeholder="Enter Labour Cost" id="cplc">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Working Hours Per Day*</label>
                                <input type="text" class="form-control onlynumbers" name="dpc" required
                                    id="cpwhpd" placeholder="Enter Working Hours Per Day">
                                <span class="workingHoursPerDayStatus fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Working Days Per Month*</label>
                                <input type="text" class="form-control onlynumbers" name="dpc" required
                                    id="cpwdpm" placeholder="Working Days Per Month">
                                <span class="workingDaysPerWeekStatus fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Petrol Cost*
                                    <select>
                                        <option value="">Hourly</option>
                                        <option value="" disabled>Daily</option>
                                        <option value="" disabled>Monthly</option>
                                    </select>
                                </label>
                                <input type="text" class="form-control onlynumbers" name="dpc" required
                                    placeholder="Petrol Cost" id="cppc">
                                <span class="petrolStatus fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Maintanance*
                                    <select id="compeMaintanancePeriod">
                                        <option value="1">Yearly</option>
                                        <option value="2" disabled>Monthly</option>
                                    </select>
                                </label>
                                <input type="text" class="form-control onlynumbers" name="maintanance" required
                                    placeholder="Maintanance Cost" id="cpmc">
                                <span class="maintananceCostStatus fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Product Cost* </label>
                                <input type="text" class="form-control onlynumbers" name="cproductcost" required
                                    placeholder="Product Cost" id="cpprco">
                                <span class="productCostStatus fielderromsg"></span>
                            </div>
                        </div>
                    </div>


                    <div id="mpdiv" style="display:none">
                        <hr>
                        <h5 class="modal-title">Makita Product</h5>
                        <hr>
                        <div class="row mtb20">
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Product Cost*</label>
                                <input type="text" class="form-control onlynumbers" name="name" required
                                    id="makitaprodcost" placeholder="Enter Product Cost">
                                <span class="makitaProductCostStatus fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Electricity Per Charge*</label>
                                <input type="text" class="form-control onlynumbers" name="name" required id="makitaprodEPC"
                                    placeholder="Enter Electricity Per Charge">
                                <span class="makitaProductElectricityPerCharge fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">No. of Charge Needed/Day*</label>
                                <input type="text" class="form-control onlynumbers" name="name" required id="makitaprodNOCNPD"
                                    placeholder="No. of Charge Needed Per Day">
                                <span class="makitaProductNoChargeNeedADay fielderromsg"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Battery Name</label>
                                <input type="text" class="form-control" name="name" required
                                    placeholder="Battery Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Battery Cost</label>
                                <input type="text" class="form-control onlynumbers" name="name" required id="makitaBateryCost"
                                    placeholder="Battery Cost">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Battery Qty</label>
                                <input type="text" class="form-control onlynumbers" name="name" required id="makitaBateryQty"
                                    placeholder="Battery Qty">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Charger Name</label>
                                <input type="text" class="form-control" name="name" required
                                    id="makitaChargerName" placeholder="Charger Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Charger Cost</label>
                                <input type="text" class="form-control onlynumbers" name="name" required
                                    id="makitaChargerCost" placeholder="Charger Cost">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Charger Quantity</label>
                                <input type="text" class="form-control onlynumbers" name="name" required
                                    id="makitaChargerQuantity" placeholder="Charger Quantity">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Total Staffs Per Day</label>
                                <input type="text" class="form-control onlynumbers" placeholder="Enter Total Staffs Per Day"
                                    id="mptspd">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Labour Cost
                                    <select>
                                        <option value="">Daily</option>
                                        <option value="" disabled>Hourly</option>
                                        <option value="" disabled>Monthly</option>
                                    </select>
                                </label>
                                <input type="text" class="form-control onlynumbers" placeholder="Enter Labour Cost"
                                    id="mplc">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputTeamName">Maintanance*
                                    <select id="makitaProdMC">
                                        <option value="1">Yearly</option>
                                        <option value="2" disabled>Monthly</option>
                                    </select>
                                </label>
                                <input type="text" class="form-control onlynumbers" name="name" required
                                    id="makitamaintanancecost" placeholder="Maintanance Cost">
                                <span class="makitaProductMaintanance fielderromsg"></span>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" id="calcinext">Next <i
                            class="fa fa-arrow-circle-right nxtbtnfaicon" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-light" id="calciprev"
                        style="display: none">Previous</button>
                    <button type="button" style="display:none" id="calcroibtn" class="btn btn-outline-light">Calculate
                        ROI</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ROI</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">ROI</li>
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
                        <div class="card card-primary">
                            <div class="card-header makitabgcolor">
                                <h3 class="card-title">ROI</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row mt-4">
                                    <div class="col-sm-4" data-toggle="modal" data-target="#modal-info">
                                        <div class="position-relative p-3 bg-gray makitacard" style="height: 130px">
                                            {{-- <div class="ribbon-wrapper ribbon-xl">
                                                <div class="ribbon bg-success text-lg" style="width: 275px">
                                                    Engine vs DC
                                                </div>
                                            </div> --}}
                                            <h2>Engine OPE Tools</h2>
                                            <h6 style="margin-left: 110px;">VS</h6>
                                            <h2>Cordless OPE Tools</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="position-relative p-3 bg-gray makitacard" style="height: 130px">
                                            {{-- <div class="ribbon-wrapper ribbon-xl">
                                                <div class="ribbon bg-warning text-lg" style="width: 275px">
                                                    AIR vs DC
                                                </div>
                                            </div> --}}
                                            <h2>AIR</h2>
                                            <h6 style="margin-left: 10px;">vs</h6>
                                            <h2>DC</h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="position-relative p-3 bg-gray makitacard" style="height: 130px">
                                            {{-- <div class="ribbon-wrapper ribbon-xl">
                                                <div class="ribbon bg-danger text-lg" style="width: 275px">
                                                    AC vs DC
                                                </div>
                                            </div> --}}
                                            <h2>AC</h2>
                                            <h6 style="margin-left: 10px;">vs</h6>
                                            <h2>DC</h2>
                                        </div>
                                    </div>
                                </div>
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
        <!-- Page specific script -->
        <script>
        $(function() {

            $("#calcinext").on('click', function() {

                    var compeWorkingHoursPerDay = $.trim($("#cpwhpd").val());
                    var compePetrolCost = $.trim($("#cppc").val());
                    var compeWorkingDaysPerMonth = $.trim($("#cpwdpm").val());
                    var compeMaintananceCost = $.trim($("#cpmc").val());
                    var compePoductCost = $.trim($("#cpprco").val());

                    if (isValueEmpty(compeWorkingHoursPerDay)) {
                        $(".workingHoursPerDayStatus").html('Working Hours Can`t Be Empty');
                    }else {
                        $(".workingHoursPerDayStatus").html('');
                    }
                    if (isValueEmpty(compeWorkingDaysPerMonth)) {
                        $(".workingDaysPerWeekStatus").html('Working Days Can`t Be Empty');
                    }else {
                        $(".workingDaysPerWeekStatus").html('');
                    }
                    if (isValueEmpty(compePetrolCost)) {
                        $(".petrolStatus").html('Petrol Cost Can`t Be Empty');
                    }else {
                        $(".petrolStatus").html('');
                    }
                    if (isValueEmpty(compeMaintananceCost)) {
                        $(".maintananceCostStatus").html('Maintanance Can`t Be Empty');
                    }else {
                        $(".maintananceCostStatus").html('');
                    }
                    if (isValueEmpty(compePoductCost)) {
                        $(".productCostStatus").html('Product Cost Can`t Be Empty');
                    }else{
                        $(".productCostStatus").html('');
                    }
                    if (compePoductCost != '' && compeWorkingHoursPerDay != '' && compeWorkingDaysPerMonth !=
                        '' && compePetrolCost != '' && compeMaintananceCost != '') {
                        $("#mpdiv").show(1000);
                        $("#cpdiv").hide(900);
                        $("#calciprev").show(900);
                        $("#calcinext").hide(900);
                        $("#calcroibtn").show(900);
                    }

                });
            $("#calciprev").on('click', function() {
                $("#mpdiv").hide(1000);
                $("#cpdiv").show(900);
                $("#calciprev").hide(900);
                $("#calcinext").show(900);
                $("#calcroibtn").hide(900);
            });

        });

        $('#calcroibtn').on('click', function() {
                var makitaProductCost = $.trim($("#makitaprodcost").val());
                var makitaProductElectricityPerCharge = $.trim($("#makitaprodEPC").val());
                var makitaProductNumberOfChargeNeedPerDay = $.trim($("#makitaprodNOCNPD").val());
                var makitaMaintananceCost = $.trim($("#makitamaintanancecost").val());
                if (isValueEmpty(makitaProductCost)) {
                    $(".makitaProductCostStatus").html('Product Cost Can`t Be Empty');
                }else {
                    $(".makitaProductCostStatus").html('');
                }
                if (isValueEmpty(makitaProductElectricityPerCharge)) {
                    $(".makitaProductElectricityPerCharge").html('Electricity Charge Mandatory');
                }else {
                    $(".makitaProductElectricityPerCharge").html('');
                }
                if (isValueEmpty(makitaProductNumberOfChargeNeedPerDay)) {
                    $(".makitaProductNoChargeNeedADay").html('Number of Charge Mandatory');
                }else {
                    $(".makitaProductNoChargeNeedADay").html('');
                }
                if (isValueEmpty(makitaMaintananceCost)) {
                    $(".makitaProductMaintanance").html('Maintanance Cost Mandatory');
                }else {
                    $(".makitaProductMaintanance").html('');
                }

            if (makitaProductCost != '' && makitaProductElectricityPerCharge != '' &&
                makitaProductNumberOfChargeNeedPerDay != '' && makitaMaintananceCost != '') {

                let params = {
                    compeProductCost: btoa($.trim($("#cpprco").val())),
                    competitorTotalStaffsPerDay: btoa($.trim($("#cptspd").val()) || ""),
                    competitorLabourCost: btoa($.trim($("#cplc").val()) || ""),
                    competitorWorkingHoursPerDay: btoa($.trim($("#cpwhpd").val())),
                    competitorWorkingDaysPerMonth: btoa($.trim($("#cpwdpm").val())),
                    competitorProdPetrolCostHourly: btoa($.trim($("#cppc").val())),
                    competitorProdMaintenanceCost: btoa($.trim($("#cpmc").val())),
                    competitorProdInitalNRuningTotalCostAyear: btoa($.trim($("#compeProdOneTotalCost").val()) || ""),
                    makitaProdCost: btoa($.trim($("#makitaprodcost").val())),
                    makitaProdElectricityPerCharge: btoa($.trim($("#makitaprodEPC").val())),
                    makitaProdBatteryCost: btoa($.trim($("#makitaBateryCost").val())),
                    makitaProdBatteryQty: btoa($.trim($("#makitaBateryQty").val())),
                    makitaProdChargerCost: btoa($.trim($("#makitaChargerCost").val())),
                    makitaProdChargerQuantity: btoa($.trim($("#makitaChargerQuantity").val())),
                    makitaProdTotalStaffsPerDay: btoa($.trim($("#mptspd").val()) || ""),
                    makitaProductLabourCost: btoa($.trim($("#mplc").val()) || ""),
                    makitaProdNoOfChargeNeededADay: btoa($.trim($("#makitaprodNOCNPD").val())),
                    makitaProductMaintenanceCost: btoa($.trim($("#makitamaintanancecost").val())),
                    makitaProdInitalNRuningTotalCostAyear: btoa($.trim($("#makitaprodyeartotalcost").val()) || ""),
                };

                // Build URL with query parameters
                let query = $.param(params);
                let url = `{{ url('admin/roi/roi-billboard') }}?${query}`;

                        window.open(url, '_blank');
            }

        });

        function isValueEmptyOrZero(value) {
                return value === '';
        }
        function isValueEmpty(value) {
            return value === '';
        }

        $(document).ready(function() {
            $('.onlynumbers').keyup(function() {
                var numbers = $(this).val();
                $(this).val(numbers.replace(/\D/, ''));
            });
        });

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        }
        </script>
    @endpush
@endsection

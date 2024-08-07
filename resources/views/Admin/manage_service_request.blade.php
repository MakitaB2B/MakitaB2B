@extends('Admin/layout')
@section('page_title', 'Service Request List | MAKITA')
@section('service_management_select', 'active')
@section('container')
    <style>
        .cp {
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 140px;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }
    </style>
    @push('styles')
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
            href="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @endpush

    <!-- The Repair Estimation Modal -->
    <div class="modal" id="gECFCModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Send Estimate To Customer</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('service-management.send-service-cost-estimation-cx') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleServiceCost">Upload Cost Estimation PDF*</label>
                                <input class="form-control" type="file" name="sr_costest_file" accept=".pdf" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputCostEstimation">Cost Estimation*</label>
                                <input type="text" class="form-control" name="cost_estimation" required
                                    id="exampleInputCostEstimation" placeholder="Enter Cost Estimation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                        <!-- /.card-body -->
                        <input type="hidden" name="trn_number" id="trnNoCostEst" required>
                        <input type="hidden" name="srslug_costest" id="srSlugCostEst" required>
                        <input type="hidden" name="cost_estslug" value={{ Crypt::encrypt(0) }} required>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The Repair Completed Modal -->
    <div class="modal" id="repaiCompleted">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Repair Completed</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p>This is to certify that the Repair has been completed, an SMS will notify the customer if you agree
                        please click on the Submit button</p>
                    <form method="POST" action={{ route('service-management.send-repair-completion-sms') }}>
                        <div class="form-group col-md-12">
                            <label>Repair Parts Details Those wer required for service*</label>
                            <textarea class="form-control" name="repair_parts_details" rows="5"
                                placeholder="Enter Repair Parts Details Those Were Required For The Service" required></textarea>
                        </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <!-- /.card-body -->
                    <input type="hidden" name="sr_repair_complete_slug" id="srcs">
                    @csrf
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- The Hand Over Tools Modal -->
    <div class="modal" id="handOverToolsModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Tools Hand Over Form</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('service-management.submit-tools-handover-data') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Handed Over Date & Time</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" name="handover_date_time"
                                        class="form-control datetimepicker-input" data-target="#reservationdatetime"
                                        required />
                                    <div class="input-group-append" data-target="#reservationdatetime"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- /.card-body -->
                        <input type="hidden" name="srslug_hod" id="srSlugHandOverDate" required>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The Reason For Over 48 Hours Modal -->
    <div class="modal" id="rfo48hModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">The Reason For Over 48 Hours</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('service-management.reason-over-48-hours') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Explain The Reason For Over 48 Hours*</label>
                                <textarea class="form-control" name="reason_over_48h" rows="5"
                                    placeholder="Explain The Reason Why SR Exited Over 48 Hours" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Part Number If It Is The Reason Of Delay</label>
                                <textarea class="form-control" name="part_number_if_reason_delay" rows="5"
                                    placeholder="Enter Part Number If It Is The Reason Of Delay"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- /.card-body -->
                        <input type="hidden" name="srslug_reasonover48h" id="srSlugTRF48H" required>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The SR Close Modal -->
    <div class="modal" id="closeSRModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Close The Service Request</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('service-management.close-sr') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>SR Closing Reason</label>
                                <textarea class="form-control" name="sr_closing_reason" rows="5"
                                    placeholder="Enter The Reason For Closing The SR"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <!-- /.card-body -->
                        <input type="hidden" name="srslug_closesr" id="srSlugCloseSr" required>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage Service Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/service-management') }}">Service
                                    Management</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Service Request</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Operate Service Request</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST"
                                action="{{ route('service-management.manage-service-requiest-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputTRN">TRN</label>
                                            <input type="text" class="form-control" value="{{ $trn }}"
                                                disabled>
                                            <input type="hidden" class="form-control" name="trn" required
                                                id="exampleInputTRN" value="{{ $trn }}">
                                            @error('trn')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputSRDate">SR Date</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ \Carbon\Carbon::parse($sr_date)->format('d-M-Y') }}">
                                            @error('sr_date')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputSC">Service Center</label>
                                            <input type="text" class="form-control"
                                                value="{{ $service_center_assigned[0]->center_name }}" disabled>
                                            <input type="hidden" name="service_center" value="{{ $service_center }}">
                                            @error('service_center')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">

                                            <label for="exampleInputRepairer">Repairer*</label>
                                            @if ($srStatus != 7)
                                                <select class="custom-select" name="repairer" required>
                                                    <option value="">Please Select A Repairer</option>
                                                    @foreach ($service_executives as $repairerList)
                                                        <option value="<?= $repairerList->employee_slug ?>"@if ($repairerList->employee_slug == $repairer)
                                                            selected
                                                    @endif><?= $repairerList->full_name ?>
                                                    </option>
                                            @endforeach
                                            </select>
                                            @error('repairer')
                                                <div
                                                    class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                    {{ $message }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control"
                                                value="{{ $empDetails[0]->full_name }}" disabled>
                                            @endif

                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputDCName">Dealer/Customer Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $delear_customer_name }}" disabled>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputContactNumber">Contact Number</label>
                                            <input type="text" class="form-control" value="{{ $contact_number }}"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputModel">Model</label>
                                            <input type="text" class="form-control" value="{{ $model }}"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputToolsSlNo">Tools Sl. No</label>
                                            <input type="text" class="form-control" value="{{ $tools_sl_no }}"
                                                disabled>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputReceiveDateTime">Receive Date Time</label>
                                            @php
                                            $receiveDateTime = \Carbon\Carbon::parse($receive_date_time);

                                            // Manually add 12 hours to convert from AM to PM if necessary
                                            if ($receiveDateTime->hour == 0) {
                                                $receiveDateTime->addHours(12);
                                            }

                                            $receivedAt = $receiveDateTime->format('d M Y, h:i:s A');

                                            @endphp
                                            <input type="text" class="form-control" disabled
                                                value="{{ $receivedAt }}">
                                        </div>
                                        @if ($estimation_date_time == null && $repairer != null)
                                            <div class="col-sm-6 col-md-4">
                                                <label for="exampleInputGECFC">.</label>
                                                <h4 class="text-center bg-lime cp" data-toggle="modal"
                                                    data-target="#gECFCModal" id="setc">Send Estimate To Customer?
                                                </h4>
                                            </div>
                                        @endif

                                        @if ($estimation_date_time != null)
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputEstimationDateTime">Estimation Date Time</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ \Carbon\Carbon::parse($estimation_date_time)->format('d M Y, H:i:s A') }}">
                                            </div>
                                        @endif

                                        @if ($estimation_date_time != null)
                                            @php
                                                $receivedat = \Carbon\Carbon::parse($receive_date_time);
                                                $estimatedat = \Carbon\Carbon::parse($estimation_date_time);
                                                $timeDifference = $receivedat->diffInMinutes($estimatedat);
                                                $hours = floor($timeDifference / 60);
                                                $minutes = $timeDifference % 60;
                                            @endphp
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputDurationAB">Duration A-B</label>
                                                <input type="text" class="form-control" disabled
                                                    id="exampleInputDurationAB"
                                                    value="{{ $hours . ' hours  ' . $minutes . '  minutes' }}">
                                                @error('duration_a_b')
                                                    <div
                                                        class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                                        {{ $message }}
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif

                                        @if ($est_date_confirm_cx != null)
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputDateConfirmByCustomer">Date Confirm By
                                                    Customer</label>
                                                <input type="text" class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($est_date_confirm_cx)->format('d M Y, H:i:s A') }}"
                                                    disabled>
                                            </div>
                                        @endif

                                        @if ($srStatus == 2)
                                            <div class="col-sm-6 col-md-6">
                                                <h4 class="text-center bg-orange color-palette"
                                                    style="color:#ffffff !important">Estimation Send To Customer Waiting On
                                                    Reply
                                                    <a href="{{ asset($costEstimationFile) }}" target="iframe_a"
                                                        style="color: black"
                                                        title="Click here to see the Estimation PDF"><i class="fa fa-eye"
                                                            aria-hidden="true"></i></a>
                                                </h4>
                                            </div>
                                            <div class="col-sm-2 col-md-2">
                                                <i class="fa fa-clone tooltiptext" aria-hidden="true"
                                                    onclick="myFunction()" onmouseout="outFunc()" id="myTooltip"
                                                    style="font-size: 20px;color: orangered;"
                                                    title="Copy Estimation Link"></i>
                                                <input type="text"
                                                    value="https://makita.ind.in/cxtoolsrepaircostestimation/{{ base64_encode($sr_slug_raw) }}"
                                                    id="costEstLink" style="display:none">
                                            </div>
                                        @endif

                                        @if ($est_date_confirm_cx != null && $repair_complete_date_time == '' && $srStatus == 3)
                                            <div class="col-sm-6 col-md-6">
                                                <h4 class="text-center bg-fuchsia color-palette cp"
                                                    style="color:#ffffff !important" data-toggle="modal"
                                                    data-target="#repaiCompleted" id="repaircomplete">Repair Completed?
                                                </h4>
                                            </div>
                                        @endif

                                        @if ($repair_complete_date_time != null)
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputRoleName">Complete Date & Time</label>
                                                <input type="text" class="form-control" disabled
                                                    value="{{ \Carbon\Carbon::parse($repair_complete_date_time)->format('d M Y, H:i:s A') }}">
                                            </div>
                                        @endif
                                        @if ($duration_c_d != null)
                                            @php
                                                $estDateConfirmCx = \Carbon\Carbon::parse($est_date_confirm_cx);
                                                $repairCompleteDate = \Carbon\Carbon::parse($repair_complete_date_time);
                                                $timeDifferenceCD = $estDateConfirmCx->diffInMinutes(
                                                    $repairCompleteDate,
                                                );
                                                $hours = floor($timeDifferenceCD / 60);
                                                $minutes = $timeDifferenceCD % 60;
                                            @endphp
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputDurationCD">Duration C-D*</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $hours . ' hours  ' . $minutes . '  minutes' }}" disabled>
                                            </div>
                                        @endif
                                        @if ($total_hour_for_repair != null)
                                            @php
                                                $totalHoursForRepair = $total_hour_for_repair;
                                                $hours = floor($totalHoursForRepair / 60);
                                                $minutes = $totalHoursForRepair % 60;
                                            @endphp
                                            <div class="form-group col-md-2">
                                                <label for="exampleInputTotalhourforrepair">Total hour for repair*</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $hours . ' hours  ' . $minutes . '  minutes' }}" disabled>
                                            </div>
                                        @endif
                                        @if ($repair_parts_details != null)
                                            <div class="form-group col-md-4">
                                                <label>Repair Parts Details</label>
                                                <textarea class="form-control" rows="2" required disabled>{{ $repair_parts_details }}</textarea>
                                            </div>
                                        @endif
                                        @if ($duration_c_d > 2880 && $reason_for_over_48h == null)
                                            <div class="form-group col-md-2">
                                                <label>.</label>
                                                <h6 class="text-center bg-maroon" data-toggle="modal"
                                                    data-target="#rfo48hModal" id="trf48h">The Reason For Over 48
                                                    Hours?
                                                </h6>
                                            </div>
                                        @endif
                                        @if ($repair_parts_details != null)
                                            @if ($handover_date_time == null)
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputGECFC">.</label>
                                                    <h4 class="text-center bg-lime cp" data-toggle="modal"
                                                        data-target="#handOverToolsModal" id="thoc">Tools Handed Over
                                                        To Customer?
                                                    </h4>
                                                </div>
                                            @else
                                                <div class="form-group col-md-2">
                                                    <label for="exampleHandoverDate">Handover Date Time</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ \Carbon\Carbon::parse($handover_date_time)->format('d M Y, H:i:s A') }}"
                                                        disabled>
                                                </div>
                                            @endif
                                            @if ($srStatus == 6)
                                                <div class="col-sm-2 col-md-2">
                                                    <label for="exampleCTSR">.</label>
                                                    <h4 class="text-center bg-maroon cp" data-toggle="modal"
                                                        data-target="#closeSRModal" id="closeSrModel">Close The SR?
                                                    </h4>
                                                </div>
                                            @endif
                                        @endif

                                        @if ($reason_for_over_48h != null)
                                            <div class="form-group col-md-6">
                                                <label>Reason for over 48 Hours</label>
                                                <textarea class="form-control" rows="2" disabled>{{ $reason_for_over_48h }}</textarea>
                                            </div>
                                        @endif
                                        @if ($part_number_reason_for_delay != null)
                                            <div class="form-group col-md-6">
                                                <label>Part Number Reason For Delayed</label>
                                                <textarea class="form-control" rows="2" disabled>{{ $part_number_reason_for_delay }}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if ($srStatus == 4)
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6">
                                            <h4 class="text-center bg-fuchsia color-palette"
                                                style="color:#ffffff !important">The Customer Has Rejected The Cost
                                                Estimation
                                            </h4>
                                        </div>
                                        <div class="form-grou col-sm-2 col-md-2">
                                            <h4 class="text-center bg-maroon cp" data-toggle="modal"
                                                data-target="#closeSRModal" id="closeSrModel">Close The SR?
                                            </h4>
                                        </div>
                                    </div>
                                @endif

                                @if ($reason_if_rejected != null)
                                    <div class="form-group col-md-12">
                                        <label>Estimation Rejection Reason</label>
                                        <textarea class="form-control" rows="2" disabled>{{ $reason_if_rejected }}</textarea>
                                    </div>
                                @endif

                                @if ($srStatus == 7)
                                    <div class="form-group col-md-12">
                                        <label>Reason For Closing SR</label>
                                        <textarea class="form-control" rows="2" disabled>{{ $sr_closing_reason }}</textarea>
                                    </div>
                                @endif
                                <div class="form-group col-md-12">
                                    <label>Tools Issue*</label>
                                    <textarea class="form-control" name="tools_issue" rows="2" placeholder="Enter Tools Issue" required>{{ $tools_issue }}</textarea>
                                    @error('tools_issue')
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            {{ $tools_issue }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    @enderror
                                </div>
                                <!-- /.card-body -->
                                @if ($srStatus != 7)
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <input type="hidden" name="srSlug" value={{ $sr_slug }} id="srSlug">
                                    <input type="hidden" name="incoming_source" value="{{ Crypt::encrypt('emp') }}"
                                        required>
                                @endif
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- InputMask -->
        <script src="{{ asset('admin_assets/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('admin_assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>
        <!-- Page specific script -->
        <script>
            function myFunction() {
                var copyText = document.getElementById("costEstLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);

                var tooltip = document.getElementById("myTooltip");
                tooltip.innerHTML = "Copied: " + copyText.value;
            }
            function outFunc() {
                var tooltip = document.getElementById("myTooltip");
                tooltip.innerHTML = "Copy Estimation Link";
            }
            $(function() {
                $("#setc").click(function() {
                    var trnNo = $.trim($("#exampleInputTRN").val());
                    var srSlug = $.trim($("#srSlug").val());
                    $("#trnNoCostEst").val(trnNo);
                    $("#srSlugCostEst").val(srSlug);
                });
                $("#repaircomplete").click(function() {
                    var srSlug = $.trim($("#srSlug").val());
                    $("#srcs").val(srSlug);
                });
                $("#thoc").click(function() {
                    var srSlug = $.trim($("#srSlug").val());
                    $("#srSlugHandOverDate").val(srSlug);
                });
                $("#closeSrModel").click(function() {
                    var srSlug = $.trim($("#srSlug").val());
                    $("#srSlugCloseSr").val(srSlug);
                });
                $("#trf48h").click(function() {
                    var srSlug = $.trim($("#srSlug").val());
                    $("#srSlugTRF48H").val(srSlug);
                });
                //Date and time picker
                $('#reservationdatetime').datetimepicker({
                    icons: {
                        time: 'far fa-clock'
                    }
                });
            });
        </script>
    @endpush
@endsection

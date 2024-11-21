@extends('Front/layout')
@section('page_title', 'Makita Tools Repair | Tools Repair List')
@section('cx_tools_repair_list', 'active')
@section('container')
@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
@endpush
<style>
.ceb{
    color: white;
    background: blueviolet;
    width: max-content;
    cursor: pointer;
    text-align: center;
}
.radio input,
.radio-inline input {
  opacity: 0;
  position: absolute;
}
.radio label {
  margin-top: 5px;
  margin-bottom: 5px;
}
.radio .indicator,
.radio-inline .indicator {
  position: relative;
}
.radio .indicator:before,
.radio-inline .indicator:before {
  content: '';
  border: 2px solid #888;
  display: inline-block;
  vertical-align: middle;
  width: 23px;
  height: 23px;
  padding: 2px;
  margin-top: -5px;
  margin-right: 10px;
  text-align: center;
}
.radio input + .indicator:before,
.radio-inline input + .indicator:before {
  border-radius: 50%;
}
.radio input:checked + .indicator:before,
.radio-inline input:checked + .indicator:before {
  border-color: #00f;
  background: #00f;
  box-shadow: inset 0px 0px 0px 5px #fff;
}
.radio input:disabled + .indicator:before,
.radio-inline input:disabled + .indicator:before {
  border-color: #ccc;
  box-shadow: inset 0px 0px 0px 5px #fff;
}
.radio input:checked:disabled + .indicator:before,
.radio-inline input:checked:disabled + .indicator:before {
  border-color: #ccc;
  background: #ccc;
  box-shadow: inset 0px 0px 0px 5px #fff;
}
.radio input:focus + .indicator,
.radio-inline input:focus + .indicator {
  outline: 0px solid #ddd;
}

.glow-on-hover {
    width: 220px;
    height: 50px;
    border: none;
    outline: none;
    color: #fff;
    background: #008290;
    cursor: pointer;
    position: relative;
    z-index: 0;
    border-radius: 10px;
}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #b30000, #D2042D, #880808, #8B0000, #800020, #008290, #00565f, #00adc0, #00e5ff);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #fff5f5;
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #ff0019;
    left: 0;
    top: 0;
    border-radius: 3px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
}
</style>
 <!-- The Repair Estimation Modal -->
 <div class="modal" id="gECFCModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Please Approve or Reject Estimation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="{{ route('accept-reject-cost-estimation-cx') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleServiceCost"><a  target="iframe_a"
                                style="color: black"
                                title="Click here to see the Estimation PDF" id="cEFHrefId">View In New Tab?</i></a></label>
                            <iframe
                            frameBorder="1" scrolling="auto" height="290px"
                            width="560px" id="cEFiframeId"></iframe>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputCostEstimation">Total Repair Cost*</label>
                            <input type="text" class="form-control" id="totalRepairCostCRCX" disabled>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleIssue" id="reasonrejectlabel" style="display:none">Enter The Reason For Rejecting(Optional)</label>
                            <textarea class="form-control" name="reason_reject" rows="5" placeholder="Enter The Reason For Rejecting" style="display:none" id="rejectreason"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="acceptrejectce" id="optionsRadiosAcceptCE" value="acceptce"><span class="indicator"></span> Accept Estimation
                              </label>
                              <label>
                                <input type="radio" name="acceptrejectce" id="optionsRadiosRejectCE" value="rejectce"><span class="indicator"></span> Reject Estimation
                              </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="display:none" id="arceb">Submit</button>
                    <!-- /.card-body -->
                    <input type="hidden" name="srslug_cear" id="srslugcear" required>
                </form>
            </div>
        </div>
    </div>
</div>

 <!-- The Team Modal -->
 <div class="modal" id="raiseNewServiceRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Service Request</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="{{ route('cx-tsr-registration') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleServiceRequest">Service Center*</label>
                            <select class="form-control" name="service_center"
                                style="width: 100%;font-size: medium !important;" required>
                                <option value="">Select FSC</option>
                                @foreach ($fscList as $fsc)
                                    <option value="{{ $fsc->fsc_slug }}">{{ $fsc->center_name }}</option>
                                @endforeach
                            </select>
                            @error('service_center')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleServiceRequest">Dealer/Customer Name*</label>
                            <input class="form-control" type="text" name="cx_name"
                                required placeholder="Enter Name">
                            @error('name')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleServiceRequest">Contact Number*</label>
                            <input class="form-control" type="text" name="cx_number"
                                required placeholder="Enter Contact Number">
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
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleServiceRequest">Model*</label>
                            <select class="form-control select2" name="model_number"
                                style="width: 100%;font-size: medium !important;" required>
                                <option value="">Select Model</option>
                                @foreach ($models as $modelList)
                                    <option value="{{ $modelList->model_number }}">{{ $modelList->model_number }}</option>
                                @endforeach
                            </select>
                            @error('model_number')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleServiceRequest">Tools Serial Number*</label>
                            <input class="form-control" type="text" name="machine_sl_no"
                                required placeholder="Enter Tools SL. No.">
                            @error('machine_sl_no')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleIssue">Issue*</label>
                            <textarea class="form-control" name="tools_issue" rows="5" placeholder="Enter tool issues that you are facing"
                                required></textarea>
                            @error('tools_issue')
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
                    <input type="hidden" name="incoming_source"  value="{{ Crypt::encrypt('cx') }}" required>
                    <input type="hidden" name="srSlug" value={{ Crypt::encrypt(0) }} required>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">

        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{session('message')}}
          </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                @php
                    $arrayCount = $toolsService->count();
                @endphp
                 <p style="color:black;font-size:15px">Raise A Tool Service Request?</p>
                 <button type="button" class="glow-on-hover" data-toggle="modal" data-target="#raiseNewServiceRequestModal">Raise New Service Request</button>
                @if ($arrayCount > 0)
                    <p style="color:#fff;font-size:15px;margin-top: 20px;font-size: x-large;background: #008290;padding: 3px;">Tools Repair List</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>TRN</th>
                                <th>Model</th>
                                <th>Serial No.</th>
                                <th>SR Date</th>
                                <th>Service Center</th>
                                <th>Tools Issue</th>
                                <th>Cost Estimation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($toolsService as $list)
                                @php
                                    $status = match ($list->status) {
                                        0 => 'Under-Diagnosing',
                                        1 => 'Repairer Assigned',
                                        2 => 'Estimation Shared',
                                        3 => 'Estimation Approved By You',
                                        4 => 'Estimation Rejected By You',
                                        5 => 'Repair Completed yet to deliverd',
                                        6 => 'Deliverd',
                                        7 => 'Closed',
                                        default => 'Contact Admin',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $list->trn }}</td>
                                    <td>{{ $list->model }}</td>
                                    <td>{{ $list->tools_sl_no }}</td>
                                    <td>{{ Carbon\Carbon::parse($list->receive_date_time)->format('d M Y') }}</td>
                                    <td>{{ $list->fscBranch->center_name }}</td>
                                    <td>{{ $list->tools_issue }}</td>
                                    @if ($list->status==2)
                                    <td data-toggle="modal"
                                    data-target="#gECFCModal" class="confirmEstimation ceb">Estimation for Repair</td>
                                    @elseif($list->status==0)
                                    <td>Waitng on cost estimation</td>
                                    @elseif ($list->status==1)
                                    <td>Repairer Assinged</td>
                                    @elseif ($list->status==3 || $list->status==4 || $list->status==5 || $list->status==6 || $list->status==7)
                                    <td>₹{{ $list->cost_estimation }}</td>
                                    @endif
                                    <td>{{ $status }}</td>
                                    <td class="srslug" style="display: none">{{ Crypt::encrypt($list->sr_slug)}}</td>
                                    <td class="totalCostEstFile" style="display: none">{{ asset($list->costestimation_file)}}</td>
                                    <td class="totalRepairCost" style="display: none">{{ $list->cost_estimation}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($arrayCount == 0)
                    <p style="color:black;font-size:15px">No record found</p>
                @endif
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
     @push('scripts')
     <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
     <!-- Page specific script -->
     <script>
        $(function() {
            $('.select2').select2()
        });
         $(function() {
            $("#optionsRadiosRejectCE").click(function() {
                $("#arceb").show();
                $("#rejectreason").show();
                $("#reasonrejectlabel").show();
            });
            $("#optionsRadiosAcceptCE").click(function() {
                $("#arceb").show();
                $("#rejectreason").hide();
                $("#reasonrejectlabel").hide();
            });

             $(".confirmEstimation").click(function() {
                 var srSlug = $.trim($(this).closest('tr').find('td.srslug').text());
                 $("#srslugcear").val(srSlug);
                 var totalRepairCost = $.trim($(this).closest('tr').find('td.totalRepairCost').text());
                 $("#totalRepairCostCRCX").val(totalRepairCost);
                 var totalCostEstFile = $.trim($(this).closest('tr').find('td.totalCostEstFile').text());
                 $("#cEFiframeId").attr("src", totalCostEstFile);
                 $("#cEFHrefId").attr("href", totalCostEstFile);
             });
         });
     </script>
    @endpush
@endsection

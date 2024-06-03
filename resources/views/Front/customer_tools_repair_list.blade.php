@extends('Front/layout')
@section('page_title', 'Makita Tools Repair | Tools Repair List')
@section('cx_tools_repair_list', 'active')
@section('container')
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
                @if ($arrayCount > 0)
                    <p style="color:black;font-size:15px">Tools Repair List</p>
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
                    <p style="color:black;font-size:15px">No record found, Raise A Tool Service Request?</p>
                    <a href="{{ url('warranty-registration-list-spec-cx') }}">
                        <button type="button" class="btn btn-success">Raise Request</button>
                    </a>
                @endif
            </div>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
     @push('scripts')
     <!-- Page specific script -->
     <script>
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

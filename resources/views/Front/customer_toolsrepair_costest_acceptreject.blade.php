@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
<style>
    .errormsg{
        width: 120px;
        text-align: center;
        background: #ef3139;
        border-radius: 1.5px;
    }
    .white{
        color: #fff;
    }
    .heading{
        height: 25px;
        margin-top: 3px;
        text-align: center;
        background: #1990a1;
        border-radius: 1.5px;
        color: #fff;
        margin-top:3px;
        border-radius: 1px;
        padding: 2px;
    }
    .bxshadow{
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    .lrtag{
        color: #1990a1;
        font-size: 11px;
        font-weight: 600;
    }
    .font10{
        font-size: 10px;
    }
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

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <x-reachus />
            <div class="col-md-8 bxshadow">

            @if($toolsRepairStatus==2)
            <p class="heading">Please Confirm The Tools Repair Cost Estimation</p>
            @if (session()->has('error'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important">
                        <div class="card-header errormsg">
                            <p class="card-title white font10">{{ session('error') }}</p>
                        </div>
                    </div>
            @elseif (session()->has('message'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important;background:#3b9900;text-align: center;border-radius: 1.5px;">
                        <div class="card-header">
                            <p class="card-title white font10">{{ session('message') }}</p>
                        </div>
                    </div>
            @endif
            <form method="POST" action="{{ route('accept-reject-cost-estimation-cx-wl') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <iframe
                            frameBorder="1" scrolling="auto" height="290px"
                            width="600px" id="cEFiframeId" src="{{ asset($costEstFile) }}"></iframe>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputCostEstimation">Total Repair Cost*</label>
                            <input type="text" class="form-control" value="{{$costEst}}" disabled>
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
                        <div class="form-group col-md-6">
                            <label for="sealerdealername">OTP<span class="required">*</span></label>
                            <input class="form-control" name="cx_cear_otp" placeholder="Enter OTP" type="text"  required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="display:none" id="arceb">Submit</button>
                    <!-- /.card-body -->
                    <input type="hidden" name="srslug_cear" id="srslugcear" required value="{{$srslug_cear}}">
            </form>
            @endif
            @php
                $status = match ($toolsRepairStatus) {
                    3 => 'Estimation Approved By You',
                    4 => 'Estimation Rejected By You',
                    5 => 'Repair Completed yet to deliverd',
                    6 => 'Deliverd',
                    7 => 'Closed',
                    default => 'Contact Admin',
                };
            @endphp
            @if ($toolsRepairStatus==3 || $toolsRepairStatus==4 || $toolsRepairStatus==5 || $toolsRepairStatus==6 || $toolsRepairStatus==7)
                <p class="heading">{{$status}}</p>
            @endif

        </div>
        </div>
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
        });
    </script>
   @endpush
@endsection

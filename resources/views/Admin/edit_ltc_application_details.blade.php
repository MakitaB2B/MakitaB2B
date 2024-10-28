@extends('Admin/layout')
@section('page_title', 'Edit LTC Application Details | MAKITA')
@section('travelmanagement-expandable', 'menu-open')
@section('travelmanagement-expandable', 'active')
@section('edit-ltc-application-details-select', 'active')
@section('container')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit LTC Application Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/holidays') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit LTC Application Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Ltc Claim Id</label>
                                        <input type="text" class="form-control" value="{{$result['ltc_claim_id']}}" id="tbe" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Employee</label>
                                        <input type="text" name="to_date" class="form-control" value="{{$result['employee']['full_name']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputfromDate">Month</label>
                                        <input type="text" name="from_date" class="form-control" value="{{$result['ltc_month']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputToDate">For The Year</label>
                                        <input type="text"  class="form-control" value="{{$result['ltc_year']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Claim Amount</label>
                                        <input type="text" id='claimamount'  class="form-control" value="{{$result['total_claim_amount']}}" disabled>
                                    </div>
                                    @php
                                    $status = match ($result['status']) {
                                    0 => 'Not Yet Reviewed By Manager',
                                    1 => 'Accepted By Manager ' . (isset($result['manager_name']['full_name']) ? $result['manager_name']['full_name'] : ''),
                                    2 => 'Rejected By Manager',
                                    3 => 'Amount Paid By ' . (isset($result['payed_by']['full_name']) ? $result['payed_by']['full_name'] : ''),
                                    4 => 'Approved By HR '. (isset($result['hr_name']['full_name']) ? $result['hr_name']['full_name'] : ''),
                                    5 => 'Rejected By HR',
                                    // 6 => 'Case Clear By Accounts',
                                    // 7 => 'Case Closed',
                                    8 => 'Rejected By Accounts',
                                    default => 'Something Wrong',
                                    };
                                    @endphp
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputToDate">Over All Status</label>
                                        <input type="text" id="overallstatus" class="form-control" value="{{$status}}" disabled>
                                    </div>
                                    {{-- <div class="form-group col-md-1">
                                        <label for="exampleInputSubmitBtn" style="color: #fff">.</label>
                                        <button type="button" class="btn btn-primary form-control" style="background-color: #008290 !important; border-color: #52eeff;" id="makepayment" {{ $result['status'] == 3 ? 'disabled' : '' }}>{{ $result['status'] == 3 ? 'Processed' : 'Process' }}</button>
                                    </div> --}}
                                    {{-- <input type="hidden" value="{{$result['ltc_claim_id']}}" id="ltcSlug"> --}}
                                    {{-- <input type="hidden" value="{{$result['employee_slug']}}" id="empSlug">  --}}
                              </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
        
                <div class="row">
                    <div class="col-md-12">
      
                        <div class="card card-primary">
                          <div class="card-header" style="background-color: #008290 !important;">
                              <h3 class="card-title">LTC Expenses Breakup</h3>
                          </div>
                          <form action="{{ route('travelmanagement.ltc-application-details-update') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                @foreach ($result['ltcClaims'] as $Data)
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Date*</label>
                                        <input type="text" class="form-control" name="date[]"  value="{{$Data['date']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Mode Of Transport*</label>
                                        <input type="text" class="form-control" name="mode_of_transport[]" value="{{$Data['mode_of_transport']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Opening Meter*</label>
                                        <input type="text" class="form-control" name="opening_meter[]" value="{{$Data['opening_meter']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Closing Meter*</label>
                                        <input type="text"  class="form-control" name="closing_meter[]" value="{{$Data['closing_meter']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Total Km*</label>
                                        <input type="text" class="form-control" name="total_km[]" value="{{$Data['total_km']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Place Visited*</label>
                                        <input type="text" class="form-control" name="place_visited[]" value="{{$Data['place_visited']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Claim Amount*</label>
                                        <input type="text" class="form-control" name="claim_amount[]"  value="{{$Data['claim_amount']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Lunch Exp*</label>
                                        <input type="text" class="form-control" name="lunch_exp[]" value="{{$Data['lunch_exp']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : ''}}> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Fuel Exp (Rs)*</label>
                                        <input type="text" class="form-control" name="fuel_exp[]" value="{{$Data['fuel_exp']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : '' }}> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Toll Charge (Rs)*</label>
                                        <input type="text" class="form-control" name="toll_charge[]" value="{{$Data['toll_charge']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : '' }}> 
                                    </div>
                                    @php
                                    $status = match ($Data["status"]) {
                                    0 => 'Not Yet Reviewed By Manager',
                                    1 => 'Accepted By Manager ',
                                    2 => 'Rejected By Manager',
                                    3 => 'Amount Paid By ',
                                    4 => 'Approved By HR ',
                                    5 => 'Rejected By HR',
                                    // 6 => 'Case Clear By Accounts',
                                    // 7 => 'Case Closed',
                                    8 => 'Rejected By Accounts',
                                    default => 'Something Wrong',
                                    };
                                    @endphp
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Status *</label>
                                        <input value="{{$status}}" type="text" class="form-control status" disabled/>
                                        {{-- <select class="ltcappstatus form-control" style="border-color: orange;" data-id="{{ $Data['ltc_claim_slug'].'-'.'ltc' }}" >
                                               <option value="0"   {{$Data["status"] == 0 ? "selected" : ""}}>In-Review</option>
                                               <option value="1"   {{$Data["status"] == 1 ? "selected" : ""}}>Approved By Manager, In Review By HR</option>
                                               <option value="2"   {{$Data["status"] == 2 ? "selected" : ""}}>Rejected By Manager</option>
                                               <option value="3"   {{$Data["status"] == 3 ? "selected" : ""}} disabled>Amount Paid</option>
                                               <option value="4"   {{$Data["status"] == 4 ? "selected" : ""}}>Approved By HR, In Review By Accounts</option>
                                               <option value="5"   {{$Data["status"] == 5 ? "selected" : ""}}>Rejected By HR</option>
                                               <option value="6"   {{$Data["status"] == 6 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Approved By Accounts</option>
                                               <option value="7"   {{$Data["status"] == 7 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Case closed</option>
                                               <option value="8"   {{$Data["status"] == 8 ? "selected" : ""}}>Rejected By Accounts</option>
                                        </select> --}}
                                        <span id="ltcappstatustxt{{$Data['ltc_claim_slug'].'-'.'ltc'}}"></span>
                                        <input type="hidden" class="ltc_claim_slug" name="ltc_claim_slug[]" value="{{$Data['ltc_claim_slug']}}" {{ $Data['status'] != 2 && $Data['status'] != 5 && $Data['status'] != 8  ? 'disabled' : '' }}/>
                                        <input type="hidden" class="ltc_claim_applications_slug" name="ltc_claim_applications_slug" value="{{$Data['ltc_claim_applications_slug']}}"/>

                                        
                                    </div>

                               </div>
                                 @endforeach
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right" style="background-color: #008290 !important; border-color: #52eeff;" id=""    {{ $result['status'] != 2 && $result['status'] != 5 && $result['status'] != 8  ? 'disabled' : '' }}>Update</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>

                <!-- /.row -->

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header" style="background-color: #008290 !important;">
                                <h3 class="card-title" >Ltc Miscellaneous Exps</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('travelmanagement.ltc-application-details-update') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Courier Bill*</label>
                                        <input type="text" class="form-control"  name="courier_bill" required
                                            id="exampleInputName" placeholder="Enter name" value="{{$result['ltcMiscellaneousExp']['courier_bill']}}" {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Xerox Stationary*</label>
                                        <input type="text" name="from_date" class="form-control" required
                                            id="exampleInputfromDate" placeholder="Enter From Date" name="xerox_stationary" value="{{$result['ltcMiscellaneousExp']['xerox_stationary']}}" {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Office Expense*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" name="office_expense" value="{{$result['ltcMiscellaneousExp']['office_expense']}}" {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }}>  
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Monthly Mobile Bills*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" name="monthly_mobile_bill" value="{{$result['ltcMiscellaneousExp']['monthly_mobile_bills']}}" {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }}>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Remarks*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="{{$result['ltcMiscellaneousExp']['remarks']}}"  {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }}>
                                    </div>

                                    @php
                                    $status = match ($result['ltcMiscellaneousExp']['status']) {
                                    0 => 'Not Yet Reviewed By Manager',
                                    1 => 'Accepted By Manager ',
                                    2 => 'Rejected By Manager',
                                    3 => 'Amount Paid By ',
                                    4 => 'Approved By HR ',
                                    5 => 'Rejected By HR',
                                    // 6 => 'Case Clear By Accounts',
                                    // 7 => 'Case Closed',
                                    8 => 'Rejected By Accounts',
                                    default => 'Something Wrong',
                                    };
                                    @endphp
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Status*</label>
                                        {{-- <select class="ltcappstatus form-control" data-id="{{ $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'].'-'.'ltcmis' }}" style="border-color: orange;">
                                            <option value="0" {{ $result['ltcMiscellaneousExp']['status'] == 0 ? "selected" : "" }}>In-Review</option>
                                            <option value="1" {{ $result['ltcMiscellaneousExp']['status'] == 1 ? "selected" : ""}}>Approved By Manager, In Review By HR</option>
                                            <option value="2" {{ $result['ltcMiscellaneousExp']['status'] == 2 ? "selected" : ""}}>Rejected By Manager</option>
                                            <option value="3" {{ $result['ltcMiscellaneousExp']['status'] == 3 ? "selected" : ""}} disabled>Amount Paid</option>
                                            <option value="4" {{ $result['ltcMiscellaneousExp']['status'] == 4 ? "selected" : ""}}>Approved By HR, In Review By Accounts</option>
                                            <option value="5" {{ $result['ltcMiscellaneousExp']['status'] == 5 ? "selected" : ""}}>Rejected By HR</option>
                                            <option value="6" {{ $result['ltcMiscellaneousExp']['status'] == 6 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Approved By Accounts</option>
                                            <option value="7" {{ $result['ltcMiscellaneousExp']['status'] == 7 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Case closed</option> 
                                            <option value="8" {{ $result['ltcMiscellaneousExp']['status'] == 8 ? "selected" : ""}}>Rejected By Accounts</option>
                                        </select> --}}

                                        <input value="{{$status}}" class="form-control" {{ $result['ltcMiscellaneousExp']['status'] != 2 && $result['ltcMiscellaneousExp']['status'] != 5 && $result['ltcMiscellaneousExp']['status'] != 8  ? 'disabled' : '' }} />
                                        <span id="ltcappstatustxt{{$result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'].'-'.'ltcmis'}}"></span>
                                        <input type="hidden" class="ltc_miscellaneous_slug" name="ltc_miscellaneous_slug" value="{{$result['ltcMiscellaneousExp']['ltc_miscellaneous_slug']}}"  {{ $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'] != 2 && $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'] != 5 && $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'] != 8  ? 'disabled' : '' }} />
                                        <input type="hidden" class="ltc_claim_applications_slug" name="ltc_claim_applications_slug" value="{{$result['ltcMiscellaneousExp']['ltc_claim_applications_slug']}}"/>
                                    </div>
                              </div>
                            </div>
                            <div class="card-footer">
                               
                             <button type="submit" class="btn btn-primary float-right" style="background-color: #008290 !important; border-color: #52eeff;" id="" {{ $result['status'] != 2 && $result['status'] != 5 && $result['status'] != 8  ? 'disabled' : '' }}>Update</button>
                            
                            </div>
                        </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->

            </div>
        </section>
      
    </div>
    @push('scripts')
        <script>

        // $(document).ready(function() {

                    
        // });

        </script>
    @endpush
@endsection






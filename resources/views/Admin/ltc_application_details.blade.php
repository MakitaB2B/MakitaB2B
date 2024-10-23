@extends('Admin/layout')
@section('page_title', 'LTC Application Details | MAKITA')
@section('travelmanagement-expandable', 'menu-open')
@section('travelmanagement-expandable', 'active')
@section('ltc-application-details-select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>LTC Application Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/holidays') }}">Home</a></li>
                            <li class="breadcrumb-item active">LTC Application Details</li>
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
                            <!-- /.card-header -->
                            <!-- form start -->

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
                                    3 => 'Amount Paid By' . (isset($result['payed_by']['full_name']) ? $result['payed_by']['full_name'] : ''),
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
                                    @if($page=='account')
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputSubmitBtn" style="color: #fff">.</label>
                                        <button type="submit" class="btn btn-primary form-control" style="background-color: #008290 !important; border-color: #52eeff;" id="makepayment">Process</button>
                                    </div>
                                    @endif
                                    <input type="hidden" value="{{$result['ltc_claim_id'].'-'.'ltc'}}" id="ltcSlug">
                                    <input type="hidden" value="{{$result['employee_slug']}}" id="empSlug"> 
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

                          @foreach ($result['ltcClaims'] as $Data)
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Date*</label>
                                        <input type="text" class="form-control" value="{{$Data['date']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Mode Of Transport*</label>
                                        <input type="text" class="form-control" value="{{$Data['mode_of_transport']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Opening Meter*</label>
                                        <input type="text" class="form-control" value="{{$Data['opening_meter']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Closing Meter*</label>
                                        <input type="text"  class="form-control" value="{{$Data['closing_meter']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Total Km*</label>
                                        <input type="text" class="form-control" value="{{$Data['total_km']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Place Visited*</label>
                                        <input type="text" class="form-control" value="{{$Data['place_visited']}}"> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Claim Amount*</label>
                                        <input type="text" class="form-control" value="{{$Data['claim_amount']}}"> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Lunch Exp*</label>
                                        <input type="text" class="form-control" value="{{$Data['lunch_exp']}}"> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Fuel Exp (Rs)*</label>
                                        <input type="text" class="form-control" value="{{$Data['fuel_exp']}}"> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Toll Charge (Rs)*</label>
                                        <input type="text" class="form-control" value="{{$Data['toll_charge']}}"> 
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Status *</label>
                                        <select class="ltcappstatus form-control" style="border-color: orange;" data-id="{{ $Data['ltc_claim_slug'].'-'.'ltc' }}" >
                                               <option value="0"   {{$Data["status"] == 0 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr' || $page == 'account'? 'disabled' : '' }}>In-Review</option>
                                               <option value="1"   {{$Data["status"] == 1 ? "selected" : ""}} {{ $page == 'account' ||  $page == 'hr' ? 'disabled' : '' }}>Approved By Manager, In Review By HR</option>
                                               <option value="2"   {{$Data["status"] == 2 ? "selected" : ""}} {{ $page == 'account' ||  $page == 'hr' ? 'disabled' : '' }}>Rejected By Manager</option>
                                               {{-- <option value="3"   {{$Data["status"] == 3 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Amount Paid</option> --}}
                                               <option value="4"   {{$Data["status"] == 4 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'account'? 'disabled' : '' }}>Approved By HR, In Review By Accounts</option>
                                               <option value="5"   {{$Data["status"] == 5 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'account'? 'disabled' : '' }}>Rejected By HR</option>
                                               {{-- <option value="6"   {{$Data["status"] == 6 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Approved By Accounts</option>
                                               <option value="7"   {{$Data["status"] == 7 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Case closed</option> --}}
                                               <option value="8"   {{$Data["status"] == 8 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Rejected By Accounts</option>
                                        </select>
                                        <span id="ltcappstatustxt{{$Data['ltc_claim_slug'].'-'.'ltc'}}"></span>
                                        <input type="hidden" class="ltcappslug" value="{{$Data['ltc_claim_applications_slug']}}" />
                                        <input type="hidden" class="page" value="{{$page}}" />
                                    </div>

                               </div>
                            </div>
                            @endforeach
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Courier Bill*</label>
                                        <input type="text" class="form-control" name="name" required
                                            id="exampleInputName" placeholder="Enter name" value="{{$result['ltcMiscellaneousExp']['courier_bill']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Xerox Stationary*</label>
                                        <input type="text" name="from_date" class="form-control" required
                                            id="exampleInputfromDate" placeholder="Enter From Date" value="{{$result['ltcMiscellaneousExp']['xerox_stationary']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Office Expense*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="{{$result['ltcMiscellaneousExp']['office_expense']}}">  
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Monthly Mobile Bills*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="{{$result['ltcMiscellaneousExp']['monthly_mobile_bills']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Remarks*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="{{$result['ltcMiscellaneousExp']['remarks']}}">
                                    </div>
                                    {{-- @php
                                    $misstatusOptions = match ($page) {
                                        'manager' => '
                                            <option value="0" ' . ($result['ltcMiscellaneousExp']['status']  == 0 ? "selected" : "") . '>In-Review</option>
                                            <option value="1" ' . ($result['ltcMiscellaneousExp']['status']  == 1 ? "selected" : "") . '>Approved By Manager, In Review By HR</option>
                                            <option value="2" ' . ($result['ltcMiscellaneousExp']['status']  == 2 ? "selected" : "") . '>Rejected By Manager</option>',
                                        'hr' => '
                                            <option value="1" ' . ($result['ltcMiscellaneousExp']['status']  == 1 ? "selected" : "") . '>Approved By Manager, In Review By HR</option>
                                            <option value="4" ' . ($result['ltcMiscellaneousExp']['status']  == 4 ? "selected" : "") . '>Approved By HR, In Review By Accounts</option>
                                            <option value="5" ' . ($result['ltcMiscellaneousExp']['status']  == 5 ? "selected" : "") . '>Rejected By HR</option>',
                                        'account' => '
                                            <option value="4" ' . ($result['ltcMiscellaneousExp']['status']  == 4 ? "selected" : "") . '>Approved By HR, In Review By Accounts</option>
                                            <option value="6" ' . ($result['ltcMiscellaneousExp']['status']  == 6 ? "selected" : "") . '>Approved By Accounts</option>
                                            <option value="7" ' . ($result['ltcMiscellaneousExp']['status']  == 7 ? "selected" : "") . '>Closed By Accounts</option>
                                            <option value="8" ' . ($result['ltcMiscellaneousExp']['status']  == 8 ? "selected" : "") . '>Rejected</option>',
                                        default => '<option value="error">Something Wrong</option>',
                                    };
                                    @endphp --}}
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Status*</label>
                                        <select class="ltcappstatus form-control" data-id="{{ $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'].'-'.'ltcmis' }}" style="border-color: orange;">
                                            <option value="0" {{ $result['ltcMiscellaneousExp']['status'] == 0 ? "selected" : "" }} {{ $page == 'manager' || $page == 'hr' || $page == 'account' ? 'disabled' : '' }} style="{{ $page == 'manager' || $page == 'hr' || $page == 'account' ? 'color: grey;' : 'color: orange;' }}">In-Review</option>
                                            <option value="1" {{ $result['ltcMiscellaneousExp']['status'] == 1 ? "selected" : ""}} {{ $page == 'account' ||  $page == 'hr' ? 'disabled' : '' }} style="{{ $page == 'account' ||  $page == 'hr' ? 'color: grey;' : 'color: orange;' }}">Approved By Manager, In Review By HR</option>
                                            <option value="2" {{ $result['ltcMiscellaneousExp']['status'] == 2 ? "selected" : ""}} {{ $page == 'account' ||  $page == 'hr' ? 'disabled' : '' }} style="{{ $page == 'account' ||  $page == 'hr' ? 'color: grey;' : 'color: orange;' }}">Rejected By Manager</option>
                                            {{-- <option value="3" {{ $result['ltcMiscellaneousExp']['status'] == 3 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Amount Paid</option> --}}
                                            <option value="4" {{ $result['ltcMiscellaneousExp']['status'] == 4 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'account'? 'disabled' : '' }}>Approved By HR, In Review By Accounts</option>
                                            <option value="5" {{ $result['ltcMiscellaneousExp']['status'] == 5 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'account'? 'disabled' : '' }}>Rejected By HR</option>
                                            {{-- <option value="6" {{ $result['ltcMiscellaneousExp']['status'] == 6 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Approved By Accounts</option>
                                            <option value="7" {{ $result['ltcMiscellaneousExp']['status'] == 7 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Case closed</option> --}}
                                            <option value="8" {{ $result['ltcMiscellaneousExp']['status'] == 8 ? "selected" : ""}} {{ $page == 'manager' ||  $page == 'hr'? 'disabled' : '' }}>Rejected By Accounts</option>
                                            
                                                {{-- {!!  $misstatusOptions  !!} --}}
                                                {{-- <option value="1" {{ $result['ltcMiscellaneousExp']['status'] == 1 ? 'selected' : '' }}>Approve By Manager, In Review By HR</option>
                                                <option value="4" {{ $result['ltcMiscellaneousExp']['status'] == 4 ? 'selected' : '' }}>Approve By HR, In Review By Accounts</option>
                                                <option value="5" {{ $result['ltcMiscellaneousExp']['status'] == 5 ? 'selected' : '' }}>Rejected By HR</option> --}}
                                        </select>
                                        <span id="ltcappstatustxt{{$Data['ltc_miscellaneous_slug'].'-'.'ltcmis'}}"></span>
                                        <input type="hidden" class="ltcappslug" value="{{$Data['ltc_claim_applications_slug']}}" />
                                    </div>
                              </div>
                            </div>
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
        <!-- Page specific script -->
        <script>

            $(document).ready(function() {

                const statusMap = {
                                    0: 'Not Yet Reviewed By Manager',
                                    1: 'Accepted By Manager & In Review for HR',
                                    2: 'Rejected By Manager',
                                    3: 'Amount Paid',
                                    4: 'Approved By HR & In Review for Accounts',
                                    5: 'Rejected By HR',
                                    // 6: 'Case Clear By Accounts',
                                    // 7: 'Case Closed',
                                    8: 'Rejected By Accounts',
                                };

                $('.ltcappstatus').on('change', function() {
                    $("#overallstatus").empty();
                    let status = $(this).val();
                    let $this = $(this);
                    let dataId = $this.data('id'); 
                    let ltcappslug = $('.ltcappslug').val();
                    let page = $('.page').val();
                 
                    //  if (status == 1 || status == 2) {
                        if (confirm("Are you sure you want to change this?")) {

                            $("#ltcappstatustxt"+dataId).html('<p style="color:green">Please Wait &#9995; ...</p>');

                                $.ajax({
                                    url: '/admin/travelmanagement/ltc-application-details/change-status',
                                    type: 'post',
                                    data: {
                                        status: status,
                                        ltcSlug: dataId,
                                        ltcappslug:ltcappslug,
                                        page:page,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(result) {

                                        // $("#overallstatus").val(result == 0 ? 'In-Review' : (result == 4 ? 'Approved By Manager' : 'Rejected'));
                                        // $("#overallstatus").val(
                                        //     result[0].status == 0 
                                        //         ? 'In-Review' 
                                        //         : (result[0].status == 1 
                                        //             ? 'Approved By ' + (result[0].manager_name.full_name ? result[0].manager_name.full_name : '') 
                                        //             : 'Rejected By ' + (result[0].manager_name.full_name ? result[0].manager_name.full_name : '')
                                        //         )
                                        // );

                                        let statusMessage = statusMap[result[0].status] || 'Something Wrong';
                                        $("#overallstatus").val(statusMessage);

                                        
                                        if (status == 1 || status == 4) {
                                            $("#ltcappstatustxt"+dataId).html('<p style="color:green">Accepted &#128077;</p>');
                                           
                                        } else if (status == 2 || status == 5 ||status== 8) {
                                            $("#ltcappstatustxt"+dataId).html('<p style="color:red">Rejected  &#128078;</p>');
                                        }
                                    },
                                    error: function(err) {
                                        alert('Error in updating status.');
                                        $("#ltcappstatustxt"+dataId).html('<p style="color:red">Failed to update. Try again.</p>');
                                    }
                                });
                            } else {
                                return false;
                            }
                        // } else {
                        //     alert('Please Select A Correct Value');
                        // }
                    });


                    $('#makepayment').on('click', function(e) {

                        let ltcappslug = $('#ltcSlug').val();

                        

                    });
                    
            });

        </script>
    @endpush
@endsection






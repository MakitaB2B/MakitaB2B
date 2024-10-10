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
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">For The Month</label>
                                        <input type="text" name="from_date" class="form-control" value="{{$result['ltc_month']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">For The Year</label>
                                        <input type="text"  class="form-control" value="{{$result['ltc_year']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Over All Status</label>
                                        <input type="text"  class="form-control" value="{{ $result['status'] == 0 ? 'In-Review' : ($result['ltc_claim_application']['status'] == 1 ? 'Approved' : 'Rejected')}}" disabled>
                                    </div>

                                    {{-- <div class="form-group col-md-1">
                                        <label for="exampleInputSubmitBtn" style="color: #fff">.</label>
                                        <button type="submit" class="btn btn-primary form-control" style="background-color: #008290 !important; border-color: #52eeff;" id="makepayment">Pay</button>
                                    </div> --}}
                                    {{-- <input type="hidden" value="" id="btaSlug">
                                    <input type="hidden" value="" id="empSlug"> --}}
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
                                        @if($Data['status'] == 0)
                                        <label for="exampleInputToDate">Status *</label>
                                        <select class="ltcappstatus form-control" style="border-color: orange;" data-id="{{ $Data['ltc_claim_slug'].'-'.'ltc' }}">
                                            <option value="in-review"
                                                {{ $Data['status'] == 0 ? 'selected' : '' }}>
                                                In-Review</option>
                                            <option value="1"
                                                {{ $Data['status'] == 1 ? 'selected' : '' }}>
                                                Approved</option>
                                            <option value="2"
                                                {{ $Data['status'] == '2' ? 'selected' : '' }}>
                                                Rejected</option>
                                        </select>
                                        @elseif ($Data['status'] == 1)
                                        <p style="color:green">Approved</p>
                                        @elseif ($Data['status'] == 2)
                                        <p style="color:red">Rejected</p>
                                        @endif
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

                                    <div class="form-group col-md-2">
                                            @if($result['ltcMiscellaneousExp']['status'] == 0)
                                            <label for="exampleInputToDate">Status*</label>
                                            <select class="ltcappstatus form-control" data-id="{{ $result['ltcMiscellaneousExp']['ltc_miscellaneous_slug'].'-'.'misc' }}" style="border-color: orange;">
                                                <option value="in-review"
                                                    {{ $result['ltcMiscellaneousExp']['status'] == 0 ? 'selected' : '' }}>
                                                    In-Review</option>
                                                <option value="1"
                                                    {{ $result['ltcMiscellaneousExp']['status'] == 1 ? 'selected' : '' }}>
                                                    Approved</option>
                                                <option value="2"
                                                    {{ $result['ltcMiscellaneousExp']['status'] == '2' ? 'selected' : '' }}>
                                                    Rejected</option>
                                            </select>
                                            @elseif ($result['ltcMiscellaneousExp']['status'] == 1)
                                            <p style="color:green">Approved</p>
                                            @elseif ($result['ltcMiscellaneousExp']['status'] == 2)
                                            <p style="color:red">Rejected</p>
                                            @endif
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

            function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            };

            $(document).ready(function() {

                $('.ltcappstatus').on('change', function() {
                    let status = $(this).val();
                    let $this = $(this);
                    let dataId = $this.data('id'); 
                     console.log(dataId);
                     if (status == 1 || status == 2) {
                        if (confirm("Are you sure you want to change this?")) {
                           
                                let $statusCell = $this.closest('tr').find('td:nth-child(8)');
                                // Show "Please Wait" message
                                $statusCell.html('<p style="color:green">Please Wait &#9995; ...</p>');

                                $.ajax({
                                    url: '/admin/travelmanagement/change-bta-applications-status-manager-approval',
                                    type: 'post',
                                    data: {
                                        status: status,
                                        btaSlug: btaSlug,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(result) {
                                        // console.log(result);
                                        // Replace "Please Wait" with final status
                                        if (status == 1) {
                                            $statusCell.html('<p style="color:green">Accepted &#128077;</p>');
                                        } else if (status == 2) {
                                            $statusCell.html('<p style="color:red">Rejected  &#128078;</p>');
                                        }
                                    },
                                    error: function(err) {
                                        alert('Error in updating status.');
                                        console.error(err);
                                        // Optionally hide the "Please Wait" message on error
                                        $statusCell.html('<p style="color:red">Failed to update. Try again.</p>');
                                    }
                                });
                            } else {
                                return false;
                            }
                        } else {
                            alert('Please Select A Correct Value');
                        }
                    });
            });






            //$(document).ready(function() {
                //$('#makepayment').on('click', function() {



                  //  let totalBTExpenses = $('#tbe').val();
                   // let btaAmountPaying = $('#amountPaying').val();
                  //  let btaSlug = $('#btaSlug').val();
                //    let empSlug = $('#empSlug').val();

              //      alert(empSlug);

            

            //    });
          //  });




                    // if (status == 1 || status == 2) {
                    //     if (confirm("Are you sure you want to change this?")) {
                    //         let btaSlug = $this.closest('tr').find('.btaslug').val();
                    //         let $statusCell = $this.closest('tr').find('td:nth-child(8)');
                    //         // Show "Please Wait" message
                    //         $statusCell.html('<p style="color:green">Please Wait &#9995; ...</p>');

                    //         $.ajax({
                    //             url: '/admin/travelmanagement/change-bta-applications-status-manager-approval',
                    //             type: 'post',
                    //             data: {
                    //                 status: status,
                    //                 btaSlug: btaSlug,
                    //                 _token: '{{ csrf_token() }}'
                    //             },
                    //             success: function(result) {
                    //                 // console.log(result);
                    //                 // Replace "Please Wait" with final status
                    //                 if (status == 1) {
                    //                     $statusCell.html('<p style="color:green">Accepted &#128077;</p>');
                    //                 } else if (status == 2) {
                    //                     $statusCell.html('<p style="color:red">Rejected  &#128078;</p>');
                    //                 }
                    //             },
                    //             error: function(err) {
                    //                 alert('Error in updating status.');
                    //                 console.error(err);
                    //                 // Optionally hide the "Please Wait" message on error
                    //                 $statusCell.html('<p style="color:red">Failed to update. Try again.</p>');
                    //             }
                    //         });
                    //     } else {
                    //         return false;
                    //     }
                    // } else {
                    //     alert('Please Select A Correct Value');
                    // }
        </script>
    @endpush
@endsection






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
                                        <input type="text" class="form-control" value="{{$result['ltc_claim_application']['ltc_claim_id']}}" id="tbe" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Employee</label>
                                        <input type="text" name="to_date" class="form-control" value="{{$result['ltc_claim_application']['employee']['full_name']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">For The Month</label>
                                        <input type="text" name="from_date" class="form-control" value="{{$result['ltc_claim_application']['ltc_month']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">For The Year</label>
                                        <input type="text"  class="form-control" value="{{$result['ltc_claim_application']['ltc_year']}}" disabled>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Over All Status</label>
                                        <input type="text"  class="form-control" value="{{ $result['ltc_claim_application']['status'] == 0 ? 'In-Review' : ($result['ltc_claim_application']['status'] == 1 ? 'Approved' : 'Rejected')}}" disabled>
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
                <!-- /.row -->

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header" style="background-color: #008290 !important;">
                                <h3 class="card-title" >Business Trip Title</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Starting Date & Time*</label>
                                        <input type="text" class="form-control" name="name" required
                                            id="exampleInputName" placeholder="Enter name" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Ending Date & Time*</label>
                                        <input type="text" name="from_date" class="form-control" required
                                            id="exampleInputfromDate" placeholder="Enter From Date" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Number of days*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Place of Visit*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="exampleInputToDate">Purpose of Visit*</label>
                                        <input type="text" name="to_date" class="form-control" required
                                            id="exampleInputToDate" placeholder="Enter To-date" value="">
                                    </div>
                              </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header" style="background-color: #008290 !important;">
                                <h3 class="card-title">Group BT Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputName">Vehicle Type*</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputfromDate">Vehicle Number*</label>
                                        <input type="text"  class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleInputToDate">Fuel Expenses*</label>
                                        <input type="text"  class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputToDate">Employee(s)*</label>
                                        <p class="form-control"> </p>
                                    </div>
                              </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->



                <div class="row">
                  <!-- left column -->
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card card-primary">
                        <div class="card-header" style="background-color: #008290 !important;">
                            <h3 class="card-title">Business Trip Expenses Breakup</h3>
                        </div>
                          <!-- /.card-header -->
                          <!-- form start -->

                        {{-- @foreach ($btaExpensesBreakup as $bebData) --}}
                          <div class="card-body">
                              <div class="row">
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputName">Date*</label>
                                      <input type="text" class="form-control" value="">
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputfromDate">Place of Visit*</label>
                                      <input type="text" class="form-control" value="">
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputToDate">Journey Fare*</label>
                                      <input type="text" class="form-control" value="">
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputToDate">Accommodation*</label>
                                      <input type="text"  class="form-control" value="">
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputToDate">Conveyance*</label>
                                      <input type="text" class="form-control" value="">
                                  </div>
                                  <div class="form-group col-md-2">
                                      <label for="exampleInputToDate">Amount (Rs)*</label>
                                      <input type="text" class="form-control" value="">
                                  </div>
                             </div>
                          </div>
                          {{-- @endforeach --}}
                      </div>
                      <!-- /.card -->
                  </div>
                  <!--/.col (left) -->
              </div>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('scripts')
        <!-- Page specific script -->
        <script>
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






@extends('Admin/layout')
@section('page_title', 'Employee Work Exprience Create|Update | MAKITA')
@section('employees_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Work Exprience Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/employee') }}">Employee List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Work Exprience</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
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
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Previous Company Documents</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('employee.manage-employee-workexp-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @php $loop_count_num=1; @endphp
                                @foreach ($empWorkExpArray as $key => $val)
                                    @php $loop_count_prev=$loop_count_num; @endphp
                                    <div class="card-body" id="previouscompany_doc_box">
                                        <input name="ewe_slug[]" type="hidden" value={{ $val['ewe_slug'] }}>
                                        <div class="row" id="prevcom_docs_"{{ $loop_count_num++ }}>
                                            <div class="form-group col-md-3">
                                                <label for="exampleCompanyName">Company Name {{ $asterisk }}</label>
                                                <input type="text" class="form-control" name="company_name[]"
                                                    value="{{ $val['company_name'] }}" id="exampleCompanyName"
                                                    placeholder="Enter Company Name" {{ $required }}>
                                                @error('company_name[0]')
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
                                            <div class="form-group col-md-3">
                                                <label for="exampleInputAppointmentLetter">Appointment
                                                    Letter{{ $asterisk }}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="appointment_letter[]"
                                                            {{ $required }}
                                                            accept=".pdf,image/png, image/jpeg,image/png">
                                                    </div>
                                                    @error('appointment_letter')
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
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="exampleInputRelievingLetter">Relieving
                                                    Letter{{ $asterisk }}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="relieving_letter[]"
                                                            accept=".pdf,image/png, image/jpeg,image/png"
                                                            {{ $required }}>
                                                    </div>
                                                    @error('relieving_letter')
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
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="exampleInputLastMonthPayslip">Last Month`s
                                                    Payslip{{ $asterisk }}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="payslip_last_month[]"
                                                            accept=".pdf,image/png, image/jpeg,image/png"
                                                            {{ $required }}>
                                                    </div>
                                                    @error('payslip_last_month')
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
                                            </div>
                                            @if ($val['appointment_letter'] || $val['relieving_letter'] || $val['payslip_last_month'] != '')
                                                <div class="form-group col-md-3"></div>
                                                <div class="form-group col-md-3">
                                                    @php
                                                        $appLetFileExtension = pathinfo($val['appointment_letter'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($appLetFileExtension != 'pdf')
                                                        <div id="img-preview" style="height: 100px">
                                                            <img src="{{ asset($val['appointment_letter']) }}"
                                                                height="80px">
                                                            <p><a href="{{ asset($val['appointment_letter']) }}"
                                                                    target="iframe_a" style="color: black"><i
                                                                        class="fa fa-eye"
                                                                        aria-hidden="true"></i>Explore?</a>
                                                        </div>
                                                    @else
                                                        <iframe src="{{ asset($val['appointment_letter']) }}"
                                                            frameBorder="0" scrolling="auto" height="150px"
                                                            width="150px"></iframe>
                                                        <p><a href="{{ asset($val['appointment_letter']) }}"
                                                                target="iframe_a" style="color: black"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-3">
                                                    @php
                                                        $relievingLetter = pathinfo($val['relieving_letter'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($relievingLetter != 'pdf')
                                                        <div id="img-preview" style="height: 100px">
                                                            <img src="{{ asset($val['relieving_letter']) }}"
                                                                height="80px">
                                                            <p><a href="{{ asset($val['relieving_letter']) }}"
                                                                    target="iframe_a" style="color: black"><i
                                                                        class="fa fa-eye"
                                                                        aria-hidden="true"></i>Explore?</a>
                                                        </div>
                                                    @else
                                                        <iframe src="{{ asset($val['relieving_letter']) }}"
                                                            frameBorder="0" scrolling="auto" height="150px"
                                                            width="150px"></iframe>
                                                        <p><a href="{{ asset($val['relieving_letter']) }}"
                                                                target="iframe_a" style="color: black"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-3">
                                                    @php
                                                        $payslipLastMonth = pathinfo($val['payslip_last_month'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($payslipLastMonth != 'pdf')
                                                        <div id="img-preview" style="height: 100px">
                                                            <img src="{{ asset($val['payslip_last_month']) }}"
                                                                height="80px">
                                                            <p><a href="{{ asset($val['relieving_letter']) }}"
                                                                    target="iframe_a" style="color: black"><i
                                                                        class="fa fa-eye"
                                                                        aria-hidden="true"></i>Explore?</a>
                                                        </div>
                                                    @else
                                                        <iframe src="{{ asset($val['payslip_last_month']) }}"
                                                            frameBorder="0" scrolling="auto" height="150px"
                                                            width="150px"></iframe>
                                                        <p><a href="{{ asset($val['payslip_last_month']) }}"
                                                                target="iframe_a" style="color: black"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="form-group col-md-3">
                                                <label for="exampleInput2ndLastMonthPayslip">2nd Last Month
                                                    Payslip{{ $asterisk }}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="payslip_2nd_last_month[]"
                                                            {{ $required }}
                                                            accept=".pdf,image/png, image/jpeg,image/png">
                                                    </div>
                                                    @error('payslip_2nd_last_month')
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
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="exampleInput3rdLastMonthPayslip">3rd Last Month
                                                    Payslip{{ $asterisk }}</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="payslip_3rd_last_month[]"
                                                            accept=".pdf,image/png, image/jpeg,image/png"
                                                            {{ $required }}>
                                                    </div>
                                                    @error('payslip_3rd_last_month')
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
                                            </div>
                                            @if ($loop_count_num == 2)
                                                <div class="form-group col-md-3">
                                                    <label for="exampleInputPCD">More Documents?</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="add_more()">Add More +</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <a
                                                    href="{{ url('admin/employee/employee-work-exp-delete') }}/{{ Crypt::encrypt($val['ewe_slug']) }}">
                                                    <button type="button" class="btn btn-danger btn-lg">
                                                        <i class="fa fa-minus"></i>&nbsp; Remove</button></a>
                                            @endif
                                            <div class="form-group col-md-3"></div>

                                            @if ($val['payslip_2nd_last_month'] || $val['payslip_3rd_last_month'] != '')
                                                <div class="form-group col-md-3">
                                                    @php
                                                        $payslip2ndLastMonth = pathinfo($val['payslip_2nd_last_month'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($payslip2ndLastMonth != 'pdf')
                                                        <div id="img-preview" style="height: 100px">
                                                            <img src="{{ asset($val['payslip_2nd_last_month']) }}"
                                                                height="80px">
                                                            <p><a href="{{ asset($val['relieving_letter']) }}"
                                                                    target="iframe_a" style="color: black"><i
                                                                        class="fa fa-eye"
                                                                        aria-hidden="true"></i>Explore?</a>
                                                        </div>
                                                    @else
                                                        <iframe src="{{ asset($val['payslip_2nd_last_month']) }}"
                                                            frameBorder="0" scrolling="auto" height="150px"
                                                            width="150px"></iframe>
                                                        <p><a href="{{ asset($val['payslip_2nd_last_month']) }}"
                                                                target="iframe_a" style="color: black"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                                        </p>
                                                    @endif

                                                </div>
                                                <div class="form-group col-md-3">
                                                    @php
                                                        $payslip3rdLastMonth = pathinfo($val['payslip_3rd_last_month'], PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($payslip3rdLastMonth != 'pdf')
                                                        <div id="img-preview" style="height: 100px">
                                                            <img src="{{ asset($val['payslip_3rd_last_month']) }}"
                                                                height="80px">
                                                            <p><a href="{{ asset($val['relieving_letter']) }}"
                                                                    target="iframe_a" style="color: black"><i
                                                                        class="fa fa-eye"
                                                                        aria-hidden="true"></i>Explore?</a>
                                                        </div>
                                                    @else
                                                        <iframe src="{{ asset($val['payslip_3rd_last_month']) }}"
                                                            frameBorder="0" scrolling="auto" height="150px"
                                                            width="150px"></iframe>
                                                        <p><a href="{{ asset($val['payslip_3rd_last_month']) }}"
                                                                target="iframe_a" style="color: black"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $emp_slug }}" name="empslug" required />
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
        <script>
            var loop_count = 1;

            function add_more() {
                loop_count++;
                //    var html='<p style="margin-top:50px;color: #007bff;">Company-> <b>'+loop_count+'</b> </p>';
                var html = '<input name="ewe_slug[]" type="hidden"><div class="row" id="prevcom_docs_' + loop_count +
                    '" style="margin-top:20px">';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleCompanyName">Company Name*</label>  <input type="text" class="form-control" name="company_name[]" required value="" id="exampleCompanyName" placeholder="Enter Company Name"></div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInputAppointmentLetter">Appointment Letter*</label> <div class="input-group"> <div class="custom-file"> <input type="file" required name="appointment_letter[]" accept=".pdf,image/png, image/jpeg,image/png"> </div> </div> </div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInputRelievingLetter">Relieving Letter*</label> <div class="input-group"> <div class="custom-file">  <input type="file" required name="relieving_letter[]" accept=".pdf,image/png, image/jpeg,image/png"> </div> </div> </div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInputLastMonthPayslip">Last Month`s Payslip*</label><div class="input-group"> <div class="custom-file"> <input type="file" required name="payslip_last_month[]" accept=".pdf,image/png, image/jpeg,image/png"> </div> </div> </div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInput2ndLastMonthPayslip">2nd Last Month Payslip*</label><div class="input-group"><div class="custom-file"> <input type="file" required name="payslip_2nd_last_month[]" accept=".pdf,image/png, image/jpeg,image/png">  </div> </div> </div>';
                html +=
                    '<div class="form-group col-md-3"> <label for="exampleInput3rdLastMonthPayslip">3rd Last Month Payslip*</label><div class="input-group"><div class="custom-file"> <input type="file" required name="payslip_3rd_last_month[]" accept=".pdf,image/png, image/jpeg,image/png" > </div> </div> </div>';
                html +=
                    '<div class="form-group col-md-3"><br><button type="button" class="btn btn-danger btn-lg" onclick=remove_more("' +
                    loop_count + '")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>';
                html += '</div>';
                jQuery("#previouscompany_doc_box").append(html);
            }

            function remove_more(loop_count) {
                jQuery('#prevcom_docs_' + loop_count).remove();
            }
        </script>
    @endpush
@endsection

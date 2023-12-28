@extends('Admin/layout')
@section('page_title', 'Employee Documents Create|Update | MAKITA')
@section('employees_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Documents Mangement Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/employee') }}">Employee List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Employee Documents</li>
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
                                <h3 class="card-title">Operate Employee Documents Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('employee.manage-employee-stiffdoc-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="examplePFUANName">PF UAN Number</label>
                                            <input type="text" class="form-control" name="pf_uan_number"
                                                value="{{$pf_uan_number}}" id="examplePFUANName"
                                                placeholder="Enter PF UAN No.">
                                            @error('pf_uan_number')
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
                                            <label for="exampleInputAadharCard">Aadhar Card{{$asterisk}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="aadhar_card" class="custom-file-input"
                                                        id="aadhar-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png" {{$required}}>
                                                    <label class="custom-file-label" for="exampleInputAadharCard">Choose
                                                        file</label>
                                                </div>
                                                @error('aadhar_card')
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
                                            <label for="exampleInputPANCard">PAN Card{{$asterisk}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="pan_card" class="custom-file-input"
                                                        id="pan-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png"  {{$required}}>
                                                    <label class="custom-file-label" for="exampleInputPANCard">Choose
                                                        file</label>
                                                </div>
                                                @error('pan_card')
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
                                            <label for="exampleInputDrivingLicence">Driving Licence</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="driving_licence" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputDrivingLicence">Choose
                                                        file</label>
                                                </div>
                                                @error('driving_licence')
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
                                        @if ($is_update=== 'true')
                                        <div class="form-group col-md-3">
                                        </div>
                                        <div class="form-group col-md-3">
                                        @php
                                            $aadharCard = pathinfo($aadhar_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($aadharCard != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($aadhar_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($aadhar_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($aadhar_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($aadhar_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            @php
                                            $panCard = pathinfo($pan_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($panCard != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($pan_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($pan_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($pan_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($pan_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            @php
                                            $drivingLicence = pathinfo($driving_licence, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($drivingLicence != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($driving_licence) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($driving_licence) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($driving_licence) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($driving_licence) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        @endif

                                        <div class="form-group col-md-3">
                                            <label for="exampleInputPassport">Passport</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="passport" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputPassport">Choose
                                                        file</label>
                                                </div>
                                                @error('passport')
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
                                            <label for="exampleInputSSLCMarksCard">SSLC Marks Card{{$asterisk}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="sslc_marks_card" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png" {{$required}}>
                                                    <label class="custom-file-label" for="exampleInputSSLCMarksCard">Choose
                                                        file</label>
                                                </div>
                                                @error('sslc_marks_card')
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
                                            <label for="exampleInputPUCMarksCard">PUC Marks Card{{$asterisk}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="puc_marks_card" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png" {{$required}}>
                                                    <label class="custom-file-label" for="exampleInputPUCMarksCard">Choose
                                                        file</label>
                                                </div>
                                                @error('puc_marks_card')
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
                                            <label for="exampleInputDegreeMarksCard">Degree Marks Card{{$asterisk}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="degree_marks_card" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png" {{$required}}>
                                                    <label class="custom-file-label" for="exampleInputDegreeMarksCard">Choose
                                                        file</label>
                                                </div>
                                                @error('degree_marks_card')
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
                                        @if ($is_update=== 'true')
                                        <div class="form-group col-md-3" {{$is_update=== 'false' ? "style=display:none":""}}>
                                            @php
                                            $passportExt = pathinfo($passport, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($passportExt != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($passport) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($passport) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($passport) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($passport) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            @php
                                            $sslcMarksCardExt = pathinfo($sslc_marks_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($sslcMarksCardExt != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($sslc_marks_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($sslc_marks_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($sslc_marks_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($sslc_marks_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            @php
                                            $pucMarksCardExt = pathinfo($puc_marks_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($pucMarksCardExt != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($puc_marks_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($puc_marks_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($puc_marks_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($puc_marks_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            @php
                                            $degreeMarksCardExt = pathinfo($degree_marks_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($degreeMarksCardExt != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($degree_marks_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($degree_marks_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($degree_marks_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($degree_marks_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        @endif

                                        <div class="form-group col-md-3">
                                            <label for="exampleInputHDMC">Higher Degree Marks Card</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="higher_degree_marks_card" class="custom-file-input"
                                                        id="choose-file"
                                                        accept=".pdf,image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputHDMC">Choose
                                                        file</label>
                                                </div>
                                                @error('higher_degree_marks_card')
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
                                        @if ($is_update=== 'true')
                                        <div class="form-group col-md-3" {{$is_update=== 'false' ? "style=display:none":""}}>

                                            @php
                                            $higherDegreeMarksCardExt = pathinfo($higher_degree_marks_card, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($higherDegreeMarksCardExt != 'pdf')
                                            <div id="img-preview" style="height: 100px">
                                                <img src="{{ asset($higher_degree_marks_card) }}"
                                                    height="80px">
                                                <p><a href="{{ asset($higher_degree_marks_card) }}"
                                                        target="iframe_a" style="color: black"><i
                                                            class="fa fa-eye"
                                                            aria-hidden="true"></i>Explore?</a>
                                            </div>
                                        @else
                                            <iframe src="{{ asset($higher_degree_marks_card) }}"
                                                frameBorder="0" scrolling="auto" height="150px"
                                                width="150px"></iframe>
                                            <p><a href="{{ asset($higher_degree_marks_card) }}"
                                                    target="iframe_a" style="color: black"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>Explore?</a>
                                            </p>
                                        @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{$emp_slug}}" name="emp_slug" required />
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
        <script src="{{ asset('admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script>
            const chooseFile = document.getElementById("aadhar-file");
            const imgPreview = document.getElementById("aadharimg-preview");

            chooseFile.addEventListener("change", function() {
                getImgData();
            });

            function getImgData() {
                const files = chooseFile.files[0];
                if (files) {
                    const fileReader = new FileReader();
                    fileReader.readAsDataURL(files);
                    fileReader.addEventListener("load", function() {
                        imgPreview.style.display = "block";
                        imgPreview.innerHTML = '<img src="' + this.result + '" style="height:100px" />';
                    });
                }
            }
            $(function() {
                bsCustomFileInput.init();
            });
        </script>
    @endpush
@endsection

@extends('Admin/layout')
@section('page_title', 'Employee Managment | MAKITA')
@section('employees_select', 'active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Mangement Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/employee') }}">Employee List</a></li>
                            <li class="breadcrumb-item active">Manage Employee</li>
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
                                <h3 class="card-title">Operate Employee Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('employee.manage-employee-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmpNo">Employee No.*</label>
                                            <input type="text" class="form-control" name="employee_no"
                                                value="{{ $employee_no }}"
                                                @if ($employee_no == '') value="{{ old('employee_no') }}" @endif
                                                id="exampleInputEmpNo" placeholder="Employee Number" required>
                                            @error('employee_no')
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
                                            <label for="exampleInputName">Full Name*</label>
                                            <input type="text" class="form-control" name="full_name"
                                                value="{{ $full_name }}"
                                                @if ($full_name == '') value="{{ old('full_name') }}" @endif
                                                id="exampleInputName" placeholder="Enter name" required>
                                            @error('full_name')
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
                                            <label for="exampleInputFatherName">Father`s Name*</label>
                                            <input type="text" class="form-control" name="father_name"
                                                value="{{ $father_name }}"
                                                @if ($father_name == '') value="{{ old('father_name') }}" @endif
                                                id="exampleInputFatherName" placeholder="Enter Father`s Name" required>
                                            @error('father_name')
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
                                            <label for="exampleInputFatherMotherName">Mother`s Name*</label>
                                            <input type="text" class="form-control" name="mother_name"
                                                value="{{ $mother_name }}"
                                                @if ($mother_name == '') value="{{ old('mother_name') }}" @endif
                                                id="exampleInputFatherMotherName" placeholder="Enter Mother`s Name"
                                                required>
                                            @error('mother_name')
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
                                            <label for="exampleInputPersonalEmail">Personal Email*</label>
                                            <input type="email" class="form-control" name="personal_email"
                                                value="{{ $personal_email }}"
                                                @if ($personal_email == '') value="{{ old('personal_email') }}" @endif
                                                id="exampleInputPersonalEmail" placeholder="Enter Personal Email" required>
                                            @error('personal_email')
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
                                            <label for="exampleInputOfficialEmail">Official Email</label>
                                            <input type="email" class="form-control" name="official_email"
                                                value="{{ $official_email }}"
                                                @if ($official_email == '') value="{{ old('official_email') }}" @endif
                                                id="exampleInputOfficialEmail" placeholder="Enter Official Email">
                                            @error('official_email')
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
                                            <label for="exampleInputPhone">Phone*</label>
                                            <input type="text" class="form-control" name="phone_number"
                                                value="{{ $phone_number }}"
                                                @if ($phone_number == '') value="{{ old('phone_number') }}" @endif
                                                id="exampleInputPhone" placeholder="Enter Phone"
                                                pattern="[0-9]{1}[0-9]{9}" maxlength="10" required>
                                            @error('phone_number')
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
                                            <label for="exampleInputAltPhone">Alt. Phone No.</label>
                                            <input type="text" class="form-control" name="alt_phone_number"
                                                value="{{ $alt_phone_number }}"
                                                @if ($alt_phone_number == '') value="{{ old('alt_phone_number') }}" @endif
                                                id="exampleInputAltPhone" placeholder="Alt. Phone Number"
                                                pattern="[0-9]{1}[0-9]{9}" maxlength="10">
                                            @error('alt_phone_number')
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
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="exampleInputdob">Date of Birth*</label>
                                            <input type="date" class="form-control" name="dob"
                                                value="{{ $dob }}" id="exampleInputexampleInputdob" required />
                                            @error('dob')
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
                                            <label for="exampleInputAge">Age*</label>
                                            <input type="text" class="form-control" name="age"
                                                value="{{ $age }}"
                                                @if ($age == '') value="{{ old('age') }}" @endif
                                                placeholder="Enter Age" id="exampleInputAge" required />
                                            @error('age')
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
                                            <label>Sex*</label>
                                            <select class="custom-select" name="sex" required>
                                                <option value="">Please Select</option>
                                                <option @if ($sex == 'male') selected @endif value="male">
                                                    Male</option>
                                                <option @if ($sex == 'female') selected @endif value="female">
                                                    Female</option>
                                            </select>
                                            @error('sex')
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
                                            <label>Marital Status*</label>
                                            <select class="custom-select" name="marital_status" required>
                                                <option value="">Please Select</option>
                                                <option @if ($marital_status == 'married') selected @endif
                                                    value="married">Married</option>
                                                <option @if ($marital_status == 'unmarried') selected @endif
                                                    value="unmarried">Unmarried</option>
                                            </select>
                                            @error('marital_status')
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
                                            <label for="exampleInputdoj">Date of Joining*</label>
                                            <input type="date" class="form-control" name="joining_date"
                                                value="{{ $joining_date }}" id="exampleInputexampleInputdoj" required />
                                            @error('joining_date')
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
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Department*</label>
                                            <select class="custom-select" name="department_id" id="department" required>
                                                <option value="">Select Department</option>
                                                @foreach ($department as $departmentData)
                                                    <option @if ($departmentData->id == $department_id) selected @endif
                                                        value="{{ $departmentData->id }}">{{ $departmentData->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('department')
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
                                            <label>Designation*</label>
                                            <select class="custom-select" name="designation_id" id="designations"
                                                required>
                                                @if ($designationbydep != '')
                                                    <option>Select Designation</option>
                                                    @foreach ($designationbydep as $designationList)
                                                        <option @if ($designationList->id == $designation_id) selected @endif
                                                            value="{{ $designationList->id }}">
                                                            {{ $designationList->designation_name }}</option>
                                                    @endforeach
                                                @else
                                                    <option>Select A Department To Fetch Designation</option>
                                                @endif
                                            </select>
                                            @error('designation_id')
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
                                            <label>Working State*</label>
                                            <select class="custom-select" name="posting_state" id="postingState"
                                                required>
                                                <option value="">Select State</option>
                                                @foreach ($states as $statesList)
                                                    <option @if ($statesList->id == $posting_state) selected @endif
                                                        value="{{ $statesList->id }}">{{ $statesList->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('posting_state')
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
                                            <label>Working City*</label>
                                            <select class="custom-select" name="posting_city" id="postingcity" required>
                                                @if ($citiesbystate != '')
                                                    <option>Select Working City</option>
                                                    @foreach ($citiesbystate as $citiesbystateList)
                                                        <option @if ($citiesbystateList->id == $posting_city) selected @endif
                                                            value="{{ $citiesbystateList->id }}">
                                                            {{ $citiesbystateList->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option>Select A State To Fetch City</option>
                                                @endif
                                            </select>
                                            @error('posting_city')
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
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Permanent Address*</label>
                                            <textarea class="form-control" name="permanent_address" rows="2" placeholder="Enter Permanent Address"
                                                required>{{ $permanent_address }}</textarea>
                                            @error('permanent_address')
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
                                        <div class="form-group col-md-6">
                                            <label>Current Address*</label>
                                            <textarea class="form-control" name="current_address" rows="2" placeholder="Enter Current Address" required>{{ $current_address }}</textarea>
                                            @error('current_address')
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
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Status*</label>
                                            <select class="custom-select" name="status" required>
                                                <option value="">Please Select</option>
                                                <option @if ($status == '1') selected @endif value="1">
                                                    Active</option>
                                                <option @if ($status == '0') selected @endif value="0">
                                                    De-Active</option>
                                            </select>
                                            @error('status')
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
                                            <label for="exampleInputFile">Passport Size Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="photo" class="custom-file-input"
                                                        id="choose-file" accept="image/png, image/jpeg,image/png">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 pid"
                                            {{ Crypt::decrypt($employee_slug) === 0 ? 'style=display:none' : '' }}>
                                            <div id="img-preview" style="height: 100px">
                                                @if ($photo != '')
                                                    <img src="{{ asset($photo) }}" height="100px">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $employee_slug }}" name="employee_slug" required />
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
            $(document).ready(function() {
                $('#department').on('change', function() {
                    let departmentID = $(this).val();
                    $('#designations').html('');
                    $.ajax({
                        url: '/admin/designation/get-designations-by-department',
                        type: 'post',
                        data: 'depID=' + departmentID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#designations').html(result);
                        }
                    });
                });
                $('#postingState').on('change', function() {
                    let stateID = $(this).val();
                    $('#postingcity').html('');
                    $.ajax({
                        url: '/admin/city/get-cities-by-state',
                        type: 'post',
                        data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#postingcity').html(result);
                        }
                    });
                });
            });
            $(function() {
                bsCustomFileInput.init();
            });
            const chooseFile = document.getElementById("choose-file");
            const imgPreview = document.getElementById("img-preview");
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
                        imgPreview.innerHTML = '<img src="' + this.result + '" style="height:100px;" />';
                        $(".pid").show();
                    });
                }
            }
        </script>
    @endpush
@endsection

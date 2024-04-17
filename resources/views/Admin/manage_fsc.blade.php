@extends('Admin/layout')
@section('page_title', 'Factory Service Centers List | MAKITA')
@section('factory_service_center_select','active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Factory Service Center Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/factory-service-center') }}">Factory Service Center List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Factory Service Center</li>
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
                                <h3 class="card-title">Operate FSC Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('fsc.manage-fsc-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label>State*</label>
                                            <select class="custom-select" name="state" id="FRCState"
                                                required>
                                                <option value="">Select State</option>
                                                @foreach ($states as $statesList)
                                                    <option @if ($statesList->id == $state_id) selected @endif
                                                        value="{{ $statesList->id }}">{{ $statesList->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('states')
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
                                            <label>Working City*</label>
                                            <select class="custom-select" name="city" id="FRCCity" required>
                                                @if ($citiesbystate != '')
                                                    <option>Select Working City</option>
                                                    @foreach ($citiesbystate as $citiesbystateList)
                                                        <option @if ($citiesbystateList->id == $city_id) selected @endif
                                                            value="{{ $citiesbystateList->id }}">
                                                            {{ $citiesbystateList->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option>Select A State To Fetch City</option>
                                                @endif
                                            </select>
                                            @error('city')
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
                                            <label for="exampleInputFSCName">FSC Name*</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{$center_name}}" required id="exampleInputFSCName"
                                                placeholder="Enter FSC Name">
                                            @error('name')
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
                                            <label for="exampleInputPhone">Phone*</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{$phone}}" required id="exampleInputPhone"
                                                placeholder="Enter Phone Number">
                                            @error('phone')
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
                                            <label for="exampleInputEmail">Email*</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{$email}}" required id="exampleInputEmail"
                                                placeholder="Enter Email">
                                            @error('email')
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
                                            <label>Status*</label>
                                            <select class="custom-select" name="status" required>
                                                <option value="">Select</option>
                                                <option @if ($status == 1) selected @endif value="1">
                                                    Active
                                                </option>
                                                <option @if ($status == 0) selected @endif value="0">
                                                    De-Active
                                                </option>
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
                                        <div class="form-group col-md-12">
                                            <label>FSC Address*</label>
                                            <textarea class="form-control" name="fsc_address" rows="2" placeholder="Enter FSC Address" required>{{ $center_address }}</textarea>
                                            @error('fsc_address')
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
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $fsc_slug }}" name="fsc_slug" required />
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
          $(document).ready(function() {
                $('#FRCState').on('change', function() {
                    let stateID = $(this).val();
                    $('#FRCCity').html('');
                    $.ajax({
                        url: '/admin/city/get-cities-by-state',
                        type: 'post',
                        data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#FRCCity').html(result);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

@extends('Admin/layout')
@section('page_title', 'Manage Location | MAKITA')
@section('expandable','menu-open')
@section('state_location_select','active')
@section('location_select','active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Location Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/location') }}">Location List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Location</li>
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
                                <h3 class="card-title">Operate Location Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('location.manage-location-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>State*</label>
                                            <select class="custom-select" name="state_id" id="state" required>
                                                <option value="0">Please Select</option>
                                                @foreach ($allstates as $stateList)
                                                    <option @if ($stateList->id == $state_id) selected @endif
                                                        value="<?= $stateList->id ?>"><?= $stateList->name ?>
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state_id')
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
                                        <div class="form-group col-md-4">
                                            <label>City</label>
                                            <select class="custom-select" name="city_id" id="city" required>
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
                                            @error('city_id')
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
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputCityName">Location Name*</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $address }}" required id="exampleInputCityName"
                                                placeholder="Enter location Name" required>
                                            @error('address')
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
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputPINCODE">PIN Code*</label>
                                            <input type="text" class="form-control" name="pin_code"
                                                value="{{ $pin_code }}" required id="exampleInputPINCODE"
                                                placeholder="Enter PIN Code" required>
                                            @error('pin_code')
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
                                        <div class="form-group col-md-4">
                                            <label>Location Status*</label>
                                            <select class="custom-select" name="status" required>
                                                <option value="">Please Select</option>
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
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" value="{{ $location_slug }}" name="location_slug" required />
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
                $('#state').on('change', function() {
                    let stateID = $(this).val();
                    $.ajax({
                        url: '/admin/city/get-cities-by-state',
                        type: 'post',
                        data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#city').html(result);
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection

@extends('Admin/layout')
@section('page_title', 'Manage City | MAKITA')
@section('expandable','menu-open')
@section('state_location_select','active')
@section('city_select','active')
@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>City Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/city') }}">City List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage DesignCityation</li>
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
                                <h3 class="card-title">Operate City Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('city.manage-city-process') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputCityName">City Name*</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $name }}" required id="exampleInputCityName"
                                                placeholder="Enter City Name">
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
                                        <div class="form-group col-md-4">
                                            <label>State</label>
                                            <select class="custom-select" name="state_id">
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
                                            <label>City Status*</label>
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
                                <input type="hidden" value="{{ $city_slug }}" name="city_slug" required />
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

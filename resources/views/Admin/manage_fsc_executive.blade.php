@extends('Admin/layout')
@section('page_title', 'Service Executives List | MAKITA')
@section('factory_service_center_select','active')
@section('container')
    <div class="content-wrapper">
        @push('styles')
            <!-- Select2 -->
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
        @endpush
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>FSC Executives</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/teams') }}">Service Center</a>
                            </li>
                            <li class="breadcrumb-item active">FSC Executives</li>
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
                                <h3 class="card-title">Operate FSC Executives Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('fsc.manage-fsc-executive-process') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($allExcByFsc as $executive)
                                            @php
                                                $fscExcRecords[] = $executive->employee_slug;
                                            @endphp
                                            <input type="hidden" name="fscexe_befor_modify[]" value="{{$executive->employee_slug}}" >
                                        @endforeach
                                        <div class="form-group col-md-8">
                                            <label>Service Executives*</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select Service Executive(s)" style="width: 100%;" name="fscexecutive[]" required>
                                                @if (count($allExcByFsc)>0)
                                                    @foreach ($allEmp as $empList)
                                                        <option value="{{Crypt::encrypt($empList->employee_slug)}}" @if (in_array($empList->employee_slug, $fscExcRecords)) selected @endif>
                                                            {{ $empList->full_name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($allEmp as $empList)
                                                    <option
                                                        value="<?=Crypt::encrypt($empList->employee_slug) ?>"><?= $empList->full_name ?>/Emp. No-> <?= $empList->employee_no ?>
                                                    </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('fscexecutive')
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
                                    <input type="hidden" name="fscSlug" value="{{$fscExc}}">
                                    <input type="hidden" name="serviceExecutiveCount" value="{{count($allExcByFsc)}}">
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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
         <!-- Select2 -->
         <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(function() {
                 //Initialize Select2 Elements
                 $('.select2').select2()
            });
        </script>
    @endpush
@endsection

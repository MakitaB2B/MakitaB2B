@extends('Admin/layout')
@section('page_title', 'Manage Admin | MAKITA')
@section('admins_select','active')
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
                        <h1>Admin Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/city') }}">Admin List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Admin</li>
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
                                <h3 class="card-title">Operate Admin Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('admins.manage-admin-process') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Employee</label>
                                            <select class="custom-select select2" name="employee_slug" required>
                                                <option value="">Please Select</option>
                                                @foreach ($allemp as $empList)
                                                    <option @if ($empList->employee_slug == $employee_slug) selected @endif
                                                        value="<?=Crypt::encrypt($empList->employee_slug) ?>"><?= $empList->full_name ?>/Emp. No-> <?= $empList->employee_no ?>
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee_slug')
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
                                        @foreach ($employee_roles as $roleExist)
                                            @php
                                                $empRoleRecords[] = $roleExist->role_slug;
                                            @endphp
                                            <input type="hidden" name="emproles_befor_modify[]" value="{{$roleExist->role_slug}}" >
                                        @endforeach
                                        <div class="form-group col-md-3">
                                            <label>Roles*</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select Role(s)" style="width: 100%;" name="roles[]" required>
                                                @if (count($employee_roles)>0)
                                                    @foreach ($roles as $roleList)
                                                        <option value="{{$roleList->role_slug}}" @if (in_array($roleList->role_slug, $empRoleRecords)) selected @endif>
                                                            {{$roleList->name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                @foreach ($roles as $roleList)
                                                        <option value="{{$roleList->role_slug}}">
                                                            {{$roleList->name}}
                                                        </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('roles')
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
                                        @foreach ($employee_permision as $permissionExist)
                                            @php
                                                $empPermissionRecords[] = $permissionExist->permission_slug;
                                            @endphp
                                            <input type="hidden" name="emppermission_befor_modify[]" value="{{$permissionExist->permission_slug}}" >
                                        @endforeach
                                        <div class="form-group col-md-3">
                                            <label>Permissions*</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select Permission(s)" style="width: 100%;" name="permissions[]" required>
                                                @if (count($employee_permision)>0)
                                                    @foreach ($permissions as $permissionist)
                                                        <option value="{{$permissionist->permission_slug}}" @if (in_array($permissionist->permission_slug, $empPermissionRecords)) selected @endif>
                                                            {{$permissionist->name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($permissions as $permissionist)
                                                        <option value="{{$permissionist->permission_slug}}">{{$permissionist->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('permissions')
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
                                        @foreach ($employee_access_modules as $existModules)
                                            @php
                                                $empModulesRecords[] = $existModules->module_slug;
                                            @endphp
                                            <input type="hidden" name="accessmodules_befor_modify[]" value="{{$existModules->module_slug}}" >
                                        @endforeach
                                        <div class="form-group col-md-3">
                                            <label>Access Modules*</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select Access Module(s)" style="width: 100%;" name="accessmodules[]" required>
                                                @if (count($employee_access_modules)>0)
                                                    @foreach ($accessmodules as $accessmodulesList)
                                                        <option value="{{$accessmodulesList->module_slug}}" @if (in_array($accessmodulesList->module_slug, $empModulesRecords)) selected @endif >
                                                            {{$accessmodulesList->name}}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($accessmodules as $accessmodulesList)
                                                        <option value="{{$accessmodulesList->module_slug}}">{{$accessmodulesList->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('accessmodules')
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
                                            <label for="exampleInputAccessID">Access ID*</label>
                                            <input type="text" class="form-control" name="access_id"
                                                value="{{ $access_id }}" required id="exampleInputAccessID"
                                                placeholder="Enter Login Access ID">
                                            @error('access_id')
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
                                            <label>Access Status*</label>
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
                                <input type="hidden" value="{{ $admin_login_slug }}" name="admin_login_slug" required />
                                <input type="hidden" value="{{ $admin_login_id }}" name="admin_login_id" required />
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

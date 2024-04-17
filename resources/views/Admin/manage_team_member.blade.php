@extends('Admin/layout')
@section('page_title', 'Team Members | MAKITA')
@section('teams_select','active')
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
                        <h1>Team Members Mangement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/teams') }}">Teams List</a>
                            </li>
                            <li class="breadcrumb-item active">Manage Team Members</li>
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
                                <h3 class="card-title">Operate Team Members Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('teams.manage-team-member-process') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($teamMembersByTeam as $temMembers)
                                            @php
                                                $teamMemberRecords[] = $temMembers->team_member;
                                            @endphp
                                            <input type="hidden" name="temamembers_befor_modify[]" value="{{$temMembers->team_member}}" >
                                        @endforeach
                                        <div class="form-group col-md-8">
                                            <label>Team Members*</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select Members(s)" style="width: 100%;" name="teammember[]" required>
                                                @if (count($teamMembersByTeam)>0)
                                                    @foreach ($allEmp as $empList)
                                                        <option value="{{Crypt::encrypt($empList->employee_slug)}}" @if (in_array($empList->employee_slug, $teamMemberRecords)) selected @endif>
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
                                    </div>
                                    <input type="hidden" name="teamSlug" value="{{$teamslug}}">
                                    <input type="hidden" name="teamMemberCount" value="{{count($teamMembersByTeam)}}">
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

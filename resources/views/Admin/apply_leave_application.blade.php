@extends('Admin/layout')
@section('page_title','Apply Leave Applications | MAKITA')
@section('employee_leave_application_select','active')
@section('container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Apply Leave</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/holidays') }}">Leave List</a></li>
              <li class="breadcrumb-item active">Apply Leave</li>
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
                <h3 class="card-title">Operate Leave Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action={{ route('employee.manage-leave-appllication-process') }}>
                @csrf
                <div class="card-body">
                 <div class="row">
                  <div class="form-group col-md-5">
                    <label for="exampleInputLeaveType">Leave Type*</label>
                    <select class="custom-select" name="leave_type" required>
                        <option value="">Please Select</option>
                        @foreach ($leave_types as $leaveTypeList )
                        <option @if ($leaveTypeList->id==$leave_type) selected  @endif  value="<?= $leaveTypeList->id?>"><?= $leaveTypeList->name?></option>
                        @endforeach
                      </select>
                    @error('leave_type')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputfromDate">Leave From Date*</label>
                    <input type="date" name="from_date" class="form-control"  value="{{ $from_date }}"  required id="exampleInputfromDate" placeholder="Enter From Date">
                    @error('from_date')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputToDate">Leave Till Date*</label>
                    <input type="date" name="to_date" class="form-control"  value="{{ $to_date }}"  required  id="exampleInputToDate" placeholder="Enter To-date">
                    @error('to_date')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                 </div>
                 <div class="row">
                    <div class="form-group col-md-12">
                        <label>Reason? *</label>
                        <textarea class="form-control" name="leave_reason" rows="3" min="2" placeholder="Enter Reason For Leave">{{ $leave_reason }}</textarea>
                    @error('leave_reason')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                <input type="hidden" value={{$emp_leave_apply_slug}} name="slug" required/>
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
@endsection

@extends('Admin/layout')
@section('page_title','Holiday Create|Update | MAKITA')
@section('holiday_select','active')
@section('container')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Holiday Mangement Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/holidays') }}">Holiday List</a></li>
              <li class="breadcrumb-item active">Manage Holiday</li>
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
                <h3 class="card-title">Operate Holidays Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action={{ route('holidays.manage-holiday-process') }}>
                @csrf
                <div class="card-body">
                 <div class="row">
                  <div class="form-group col-md-4">
                    <label for="exampleInputName">Name*</label>
                    <input type="text" class="form-control" name="name" @if($name=='')value="{{ old('name') }}"  @endif value="{{ $name }}"  required id="exampleInputName" placeholder="Enter name">
                    @error('name')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-2">
                    <label for="exampleInputfromDate">From Date*</label>
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
                  <div class="form-group col-md-2">
                    <label for="exampleInputToDate">To Date*</label>
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
                  <div class="form-group col-md-2">
                    <label>Holiday Type*</label>
                    <select class="custom-select" name="holidaytype" required>
                      <option value="">Please Select</option>
                      @foreach ($holiday_types as $holidayList )
                      <option @if ($holidayList->id==$type) selected  @endif value="<?= $holidayList->id?>"><?= $holidayList->name?></option>
                      @endforeach
                    </select>
                    @error('holidaytype')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-2">
                    <label>States*</label>
                    <select class="custom-select" name="state" required>
                      <option value="" disabled>Please State</option>
                      <option value="56">All States</option>
                      @foreach ($states as $stateList )
                      <option @if ($holidayList->id==$state) selected  @endif  value="<?= $stateList->id?>"><?= $stateList->name?></option>
                      @endforeach
                    </select>
                    @error('holidaytype')
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
                        <label>Notes</label>
                        <textarea class="form-control" name="holiday_notes" rows="3" min="2" placeholder="Enter Holiday Description">{{ $notes }}</textarea>
                    @error('holiday_notes')
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
                <input type="hidden" value={{$slug}} name="slug" required/>
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

@extends('Admin/layout')
@section('page_title','Leave Applications List | MAKITA')
@section('employee_leave_application_select','active')
@section('container')
<div class="content-wrapper">
    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    @endpush


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <a href="{{ url('admin/employee/manage-leave-application') }}"><button type="button" class="btn btn-block btn-primary">Apply Leave</button></a>
          </div>
          <div class="col-sm-10">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Leave Applications</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Leave Applications</h3>
                @if (session()->has('message'))
                <br>
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ session('message') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Emp Name</th>
                    <th>Leave Type</th>
                    <th>Leave From</th>
                    <th>Leave Till</th>
                    <th>Status</th>
                    <th>Responsed By</th>
                    <th>Responsed Date</th>
                    <th>Comments</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($result as $key=>$list)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $list->employee_slug }}</td>
                    <td>{{ $list->leave_type }}</td>
                    <td>{{ $list->from_date }}</td>
                    <td>{{ $list->to_date }}</td>
                    <td>{{ $list->approval_status }}</td>
                    <td>{{ $list->responsedby_empslug }}</td>
                    <td>{{ $list->response_datetime }}</td>
                    <td><a href="{{ url('admin/holidays/manage-holiday')}}/{{ Crypt::encrypt($list->emp_leave_apply_slug) }}" title="Edit"> <i class="nav-icon fas fa-edit"></i></a></td>
                  </tr>
                  @endforeach

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Emp Name</th>
                    <th>Leave Type</th>
                    <th>Leave From</th>
                    <th>Leave Till</th>
                    <th>Status</th>
                    <th>Responsed By</th>
                    <th>Responsed Date</th>
                    <th>Comments</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@endpush
@endsection

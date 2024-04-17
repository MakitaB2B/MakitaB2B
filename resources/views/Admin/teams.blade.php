@extends('Admin/layout')
@section('page_title','Teams List | MAKITA')
@section('teams_select','active')
@section('container')
<div class="content-wrapper">
    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_assets//plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    @endpush

 <!-- The Team Modal -->
 <div class="modal" id="teamCreateModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Create New Team</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form method="POST" action={{ route('teams.manage-team-process') }}>
                @csrf
                 <div class="row">
                  <div class="form-group col-md-12">
                    <label for="exampleInputTeamName">Team Name*</label>
                    <input type="text" class="form-control" name="name"  required id="exampleInputTeamName" placeholder="Enter team name">
                    @error('name')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @enderror
                  </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Submit</button>
                 <input type="hidden" name="teamSlug" value="{{Crypt::encrypt(0)}}">
                <!-- /.card-body -->
              </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#teamCreateModal">Add Team</button>
          </div>
          <div class="col-sm-10">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Teams</li>
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
                <h3 class="card-title">Teams List</h3>
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
                    <th>Team Name</th>
                    <th>Team Owner</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($teamList as $key=>$list)
                  <tr>
                    <td class="getSlug"><span
                        style="display: none">{{ Crypt::encrypt($list->team_slug) }}-</span>{{ $key+1 }}</td>
                    <td contenteditable="true" >{{ $list->team_name }}</td>
                    <td>{{$list->employee->full_name}} </td>
                    <td><a href="{{ url('admin/teams/manage-team-members/')}}/{{ Crypt::encrypt($list->team_slug) }}" title="Add Team Members"> <i class="nav-icon fa fa-user-plus"></i></a></td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Team Name</th>
                    <th>Team Owner</th>
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
    let teamLastString;
    $('td').on('click', function() {
        teamLastString = $(this).text();
    });
    $("td[contenteditable=true]").blur(function() {
        var teamValue = $(this).text();
        var teamSlugStr = $(this).closest('tr').find('td.getSlug').text();
        let teamSlugSplit = teamSlugStr.split('-');
        let teamSlug = $.trim(teamSlugSplit[0]);

        var splitTeamUpdatedStr=teamValue.split(":");
        var teamUpdatedVal=$.trim(splitTeamUpdatedStr[1]);

        var splitTeamLastString=teamLastString.split(":");
        var teamLastVal=$.trim(splitTeamLastString[1]);

        if(teamUpdatedVal!=teamLastString){
            $.post('/admin/teams/manage-team-process', 'name=' + teamValue + '&teamSlug=' + teamSlug + '&_token={{ csrf_token() }}', function(data) {
            // if (data != '') {
            //     // message_status.show();
            //     // message_status.text(data);
            //     // //hide the message
            //     // setTimeout(function() {
            //     //     message_status.hide()
            //     // }, 1000);
            //     console.log(data);
            // }else{
            //     console.log(data);
            // }
            });
        }
    });




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

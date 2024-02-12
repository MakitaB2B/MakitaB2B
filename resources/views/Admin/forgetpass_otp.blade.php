<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Makita | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <a href="{{url('admin/register')}}" class="h1"><b>Ma</b>Kita</a>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Please Enter OTP</p>
            <form action="{{ route('admin.empfpotpv') }}" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="otp" placeholder="Enter OTP" maxlength="6"
                autocomplete="off" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Send</button>
                </div>
                <!-- /.col -->
              </div>
              @csrf
              <input type="hidden" value="{{$empSlug}}" name="empslug" required>
            </form>
            <p class="mt-3 mb-1">
              <a href="{{url('admin/login')}}">Login?</a>
            </p>
          </div>
          <!-- /.login-card-body -->
        </div>
      </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_assets/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#passeyopen").hide();
            $("#passeyslsh").click(function() {
                $("#passeyslsh").hide();
                $("#passeyopen").show();
                $('#passfield').get(0).type = 'text';
            });
            $("#passeyopen").click(function() {
                $("#passeyopen").hide();
                $("#passeyslsh").show();
                $('#passfield').get(0).type = 'password';
            });
        });
    </script>
</body>

</html>

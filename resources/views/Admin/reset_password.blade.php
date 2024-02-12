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
            <a href="#" class="h1"><b>Ma</b>Kita</a>
          </div>
          <div class="card-body">
            @if (session()->has('message'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important">
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
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
            <form action="{{ route('admin.empresetpass') }}" method="post">
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
                @error('password')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @enderror
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
                @error('password_confirmation')
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @enderror
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Change password</button>
                </div>
                <!-- /.col -->
              </div>
              @csrf
              <input type="hidden" value="{{$empSlug}}" name="empslug" required>
            </form>

            <p class="mt-3 mb-1">
              <a href="{{url('admin/login')}}">Login</a>
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

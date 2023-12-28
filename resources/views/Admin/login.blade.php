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
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('admin/login') }}" class="h1" style="font-size: 1.9rem"><b>Makita</b></a>
            </div>
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important">
                        <div class="card-header">
                            <h3 class="card-title">{{ session('error') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.auth') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="userid" class="form-control" required placeholder="User ID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" required placeholder="Password" id="passfield">
                        <div class="input-group-append">
                            <div class="input-group-text" id="passeyopen">
                                <span class="fas fa-eye"></span>
                            </div>
                            <div class="input-group-text" id="passeyslsh">
                                <span class="fas fa-eye-slash"></span>
                            </div>
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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

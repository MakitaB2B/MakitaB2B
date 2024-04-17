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
    <style>
        /* Style all input fields */
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Style the submit button */
        input[type=submit] {
            background-color: #0f0fe9;
            color: white;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #4141fc;
        }

        /* The message box */
        #password-message {
            display: none;
            background: #ffffff;
            color: #000;
            position: relative;
            padding: 2px;
            margin-top: 10px;
            text-align: left;
        }

        #password-message h3 {
            font-size: 12px;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #password-message p {
            margin: 8px 0;
        }

        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "";
        }

        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "";
        }

        /* Error message style */
        .error-msg {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .bxshadow {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .heading {
            text-align: center;
            background: #1990a1;
            border-radius: 1.5px;
            color: #fff;
            cursor: pointer;
        }
    </style>
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
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.
                </p>
                <form action="{{ route('admin.empresetpass') }}" method="post">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password"
                            id="password"  autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number,
            one uppercase and lowercase letter, and at least 8 characters"
                            required >
                        <div class="input-group-append">
                            <div class="input-group-append">
                                <div class="input-group-text" id="passeyopen">
                                    <span class="fas fa-eye"></span>
                                </div>
                                <div class="input-group-text" id="passeyslsh">
                                    <span class="fas fa-eye-slash"></span>
                                </div>
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
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Confirm Password" id="confirmpassword"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
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
                    <span id='message'></span>
                    <div id="password-message">
                        <h3>Password must contain:</h3>
                        <p class="password-message-item invalid">At least
                            <b>one lowercase letter</b>
                        </p>
                        <p class="password-message-item invalid">At least
                            <b>one uppercase letter</b>
                        </p>
                        <p class="password-message-item invalid">At least
                            <b>one number</b>
                        </p>
                        <p class="password-message-item invalid">Minimum
                            <b>8 characters</b>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" id="submitfrom">Change
                                password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    @csrf
                    <input type="hidden" value="{{ $empSlug }}" name="empslug" required>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ url('admin/login') }}">Login</a>
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

            $('#submitfrom').prop('disabled', true);

            // script.js File
            var passwordInput = document.getElementById("password");
            var passwordMessageItems = document.getElementsByClassName("password-message-item");
            var passwordMessage = document.getElementById("password-message");


            passwordInput.onfocus = function() {
                passwordMessage.style.display = "block";
            }

            // After clicking outside of password input hide the message
            passwordInput.onblur = function() {
                passwordMessage.style.display = "none";
            }

            passwordInput.onkeyup = function() {
                // checking uppercase letters
                let uppercaseRegex = /[A-Z]/g;
                if (passwordInput.value.match(uppercaseRegex)) {
                    passwordMessageItems[1].classList.remove("invalid");
                    passwordMessageItems[1].classList.add("valid");
                } else {
                    passwordMessageItems[1].classList.remove("valid");
                    passwordMessageItems[1].classList.add("invalid");
                }

                // checking lowercase letters
                let lowercaseRegex = /[a-z]/g;
                if (passwordInput.value.match(lowercaseRegex)) {
                    passwordMessageItems[0].classList.remove("invalid");
                    passwordMessageItems[0].classList.add("valid");
                } else {
                    passwordMessageItems[0].classList.remove("valid");
                    passwordMessageItems[0].classList.add("invalid");
                }

                // checking the number
                let numbersRegex = /[0-9]/g;
                if (passwordInput.value.match(numbersRegex)) {
                    passwordMessageItems[2].classList.remove("invalid");
                    passwordMessageItems[2].classList.add("valid");
                } else {
                    passwordMessageItems[2].classList.remove("valid");
                    passwordMessageItems[2].classList.add("invalid");
                }

                // Checking length of the password
                if (passwordInput.value.length >= 8) {
                    passwordMessageItems[3].classList.remove("invalid");
                    passwordMessageItems[3].classList.add("valid");
                } else {
                    passwordMessageItems[3].classList.remove("valid");
                    passwordMessageItems[3].classList.add("invalid");
                }
            }

            $('#password, #confirmpassword').on('keyup', function() {
                let passval = $('#password').val();
                let confirmpassval = $('#confirmpassword').val();
                if (passval != '' && confirmpassval != '') {
                    if ($('#password').val() == $('#confirmpassword').val()) {
                        $('#submitfrom').prop('disabled', false);
                        $('#message').html('Password Match').css('color', 'green');
                        $('#password,#confirmpassword').css('border', '1px solid rgb(36 159 30)');
                    } else {
                        $('#submitfrom').prop('disabled', true);
                        $('#message').html('The Password doesn`t Match').css('color', 'red');
                        $('#confirmpassword,#password').css('border', '1px solid #f60808');
                    }
                }
            });
            $("#passeyopen").hide();
            $("#passeyslsh").click(function() {
                $("#passeyslsh").hide();
                $("#passeyopen").show();
                $('#password').get(0).type = 'text';
            });
            $("#passeyopen").click(function() {
                $("#passeyopen").hide();
                $("#passeyslsh").show();
                $('#password').get(0).type = 'password';
            });

        });
    </script>
</body>

</html>

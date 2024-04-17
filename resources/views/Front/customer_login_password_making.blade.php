@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
    <style>
        /* Style all input fields */
        input {
            width: 100%;
            padding: 12px;
            margin: 6px 0 16px 0;
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
        .bxshadow{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        .heading{
            text-align: center;
            background: #1990a1;
            border-radius: 1.5px;
            color: #fff;
            cursor: pointer;
        }
    </style>
    @php
    if(!empty($flag)){
        if (Crypt::decrypt($flag)==1){
            $tagLine="Reset Password";
            $passwordLevel= "New Password";
            $route="cx-login-password-reset";
        }
    }else{
            $tagLine="Create Password";
            $passwordLevel= "Password";
            $route="cx-login-password-dbinsert";
    }
    @endphp

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <div class="row">
            <x-reachus />
            <form method="post" action="{{ route($route) }}">
                <div class="col-md-8 bxshadow">
                    <div class="row">
                        <p class="heading">{{$tagLine}}</p>
                        <div class="col-sm-6 form-group">
                            <label for="password">{{$passwordLevel}}<span class="required">*</span></label>
                            <input class="form-control" id="password" name="password" placeholder="Enter Password"
                                type="text" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Must contain at least one number,
                            one uppercase and lowercase letter, and at least 8 characters"
                                required autocomplete="off">
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
                            @error('password')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="confirmpassword">Confirm Password<span class="required">*</span></label>
                            <input class="form-control" id="confirmpassword" name="password_confirmation"
                                placeholder="Enter Confirm Password" type="text" required autocomplete="off">
                            <span id='message'></span>
                            @error('password_confirmation')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn pull-right" type="submit" id="submitfrom">Send</button>
                        </div>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="cxslug" value="{{ $cxslug }}" required>
                <input type="hidden" name="flag" value="{{ $flag }}" required>
            </form>
        </div>
        <br>
        <x-warrantypolicy />
        @push('scripts')
            <script>
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
            </script>
        @endpush
    </div>
@endsection

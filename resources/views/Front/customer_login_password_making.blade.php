
@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
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
<main class="main-content bg-grey">
    <div class="container">
        <div class="content">
            <div class="left-side">
            <div class="content-info">                            
                <div class="card-container">
                        <div class="steps-grid">
                          <div class="step-card">
                            <div class="step-number">01</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                  <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                              </div>
                              <h2 class="step-title">{{$tagLine}}</h2>
                              <p class="step-description">Create a account or <a href="index.html">signin</a> to access warranty services portal.</p>
                            </div>
                          </div>
                    
                          <div class="step-card">
                            <div class="step-number">02</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Mobile Number</h2>
                              <p class="step-description">Enter the mobile number and press continue to proceed.</p>
                            </div>
                          </div>                                 
                    
                          <div class="step-card">
                            <div class="step-number">03</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">OTP</h2>
                              <p class="step-description">Enter the OTP received on your mobile and press verify OTP to continue.</p>
                            </div>
                          </div>
                          <div class="step-card">
                            <div class="step-number">04</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Peronal Details</h2>
                              <p class="step-description">Enter your personal details along with your address.</p>
                            </div>
                          </div>
                    
                          <div class="step-card">
                            <div class="step-number">05</div>
                            <div class="step-content">
                              <div class="step-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                              </div>
                              <h2 class="step-title">Review & Submit</h2>
                              <p class="step-description">Verify all information and submit your request for processing.</p>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
        </div>
            <div class="right-side">
                <div class="card-s">
                    <div class="auth-container" id="signupPage">
                        <div class="auth-header">
                            <h1>Create Account</h1>
                            <p>Please complete all steps to register</p>
                        </div>
            
                        <div class="steps-container">
                            <div class="step">
                                <div class="step-circle">1</div>
                                <div class="step-text">Number</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">2</div>
                                <div class="step-text">OTP</div>
                            </div>
                            <div class="step">
                                <div class="step-circle active">3</div>
                                <div class="step-text">Password</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">4</div>
                                <div class="step-text">Details</div>
                            </div>
                            
                        </div>
            
                        {{-- <form class="step-form active" id="step1Form" action="{{ route('cx-signup-otp-send') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="mobileNumber">Enter Mobile Number</label>
                                <input type="tel" id="mobileNumber" placeholder="Enter your mobile number" name="mobile_number" value="{{ $mobile_number }}" required>
                            </div>
                            @error('mobile_number')
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @enderror
                            <button type="submit" class="btn-primary">Continue</button>
                            <input type="hidden" name="cxslug" value="{{ Crypt::encrypt($cxslug) }}">
                            <input type="hidden" name="forgetpassword" value="{{ $forgetpassword }}">
                        </form> --}}
            
                        {{-- <form class="step-form active" id="step2Form">
                            <div class="form-group">
                                <label>Enter OTP sent to your mobile +91 {{ Str::mask($mobile_number, '*', -9, 6) }}</label>
                                <div class="otp-inputs">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                    <input class="otpstr" type="text" maxlength="1" pattern="\d">
                                </div>
                                <p id="otpprocess" style="display: none;color:rgb(0, 134, 4);fot-size:20px">Please Wait While OTP Processing</p>
                                <p id="wrongotp" style="display: none;color:red;fot-size:20px">You have entered wrong OTP</p>
                                <p class="resendotp" id="resendotp" style="display: none">Resend OTP?</p>
                                <div class="otptimer">Resend OTP in <span id="timer"></span> Seconds</div>
                            </div>
                        </form> --}}
                        <form class="step-form active" id="step3Form" method="post" action="{{ route($route) }}">
                            @csrf
                            <div class="f-col">
                              <div class="form-group">
                                  <label for="password">{{$passwordLevel}}<span class="required">*</span></label>
                                  <input class="form-control" id="password" name="password" placeholder="Enter Password"
                                  type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
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
                                  {{-- <input type="password" id="name" placeholder="Password" required> --}}
                              </div>
                              {{-- <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" id="email" placeholder="Enter your email" required>
                              </div> --}}
                            </div>
                            <div class="f-col">
                                <div class="form-group">
                                    <label for="password">Confirm Password*</label>
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
                              
                              {{-- <div class="form-group">
                                <label for="">City*</label>
                                <div class="custom-select-container" id="cityID">
                                    <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                    <div class="dropdown-arrow"></div>
                                    <div class="custom-select-dropdown">
                                        <input type="text" class="search-box" placeholder="Type to search...">
                                        <div class="options-container"></div>
                                    </div>
                                </div>
                            </div> --}}

                            @csrf
                            <input type="hidden" name="cxslug" value="{{ $cxslug }}" required>
                            <input type="hidden" name="flag" value="{{ $flag }}" required>
                            </div>
                            <button type="submit" class="btn-primary">Complete Registration</button>
                        </form>

                        {{-- <form class="step-form" id="step4Form">
                            <div class="f-col">
                              <div class="form-group">
                                  <label for="name">Full Name</label>
                                  <input type="text" id="name" placeholder="Enter your full name" required>
                              </div>
                              <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" id="email" placeholder="Enter your email" required>
                              </div>
                            </div>
                            <div class="f-col">
                              <div class="form-group">
                                <label for="">State*</label>
                                <div class="custom-select-container" id="stateID">
                                      <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                      <div class="dropdown-arrow"></div>
                                      <div class="custom-select-dropdown">
                                          <input type="text" class="search-box" placeholder="Type to search...">
                                          <div class="options-container"></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="">City*</label>
                                <div class="custom-select-container" id="cityID">
                                    <input type="text" class="custom-select-input" readonly placeholder="Select an option...">
                                    <div class="dropdown-arrow"></div>
                                    <div class="custom-select-dropdown">
                                        <input type="text" class="search-box" placeholder="Type to search...">
                                        <div class="options-container"></div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                              <label>Address</label>
                              <textarea placeholder="Enter your comment here" name="comment"></textarea>
                              </div>
                            <button type="submit" class="btn-primary">Complete Registration</button>
                        </form> --}}
            
                        <div class="auth-links">
                            <a href="{{ url('cx-login') }}">Already have an account? Login here</a>
                        </div>
                        <div class="contact-info">
                            <p>Need help? Contact us at:</p>
                            <div class="contact-details">
                                <p><span>📍 Reach us at</span> :  Bangalore, India</p>
                                <p><span>📞 Call us at</span> :  +91-80-2205-8200</p>
                                <p><span>✉️ Contact us at</span> : <a href="mailto:sales@makita.in">sales@makita.in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#signupPage').length > 0) {
            $(".steps-grid .step-card").hide();
            $(".steps-grid .step-card:nth-child(2)").addClass("active-card")
            $(".steps-grid .step-card:nth-child(-n+2)").show();                
        }
    });
</script>
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
@endsection



{{-- old ui --}}
{{-- @extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
    <style>
        input {
            width: 100%;
            padding: 12px;
            margin: 6px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #0f0fe9;
            color: white;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #4141fc;
        }
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
                var passwordInput = document.getElementById("password");
                var passwordMessageItems = document.getElementsByClassName("password-message-item");
                var passwordMessage = document.getElementById("password-message");


                passwordInput.onfocus = function() {
                    passwordMessage.style.display = "block";
                }

                passwordInput.onblur = function() {
                    passwordMessage.style.display = "none";
                }

                passwordInput.onkeyup = function() {
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
@endsection --}}

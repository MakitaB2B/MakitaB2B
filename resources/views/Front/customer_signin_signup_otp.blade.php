
@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer SignUp OTP')
@section('cxsignup_select', 'active')
@section('container')
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
                              <h2 class="step-title">Create Account</h2>
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
                                <div class="step-circle active">2</div>
                                <div class="step-text">OTP</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">3</div>
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
            
                        <form class="step-form active" id="step2Form">
                            <div class="form-group">
                                <label>Enter OTP sent to your mobile +91 {{ Str::mask($mobile_number, '*', -9, 6) }}</label>
                                {{-- <p>OTP sent on +91 {{ Str::mask($mobile_number, '*', -9, 6) }} <a
                                    href="{{ url('cx-signup') }}/{{ $cxSlug }}" title="Update Mobile Number">
                                    <span class="glyphicon glyphicon-pencil pencil"></span></a> </p> --}}
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
                            {{-- <button type="submit" class="btn-primary">Verify OTP</button> --}}
                        </form>
            
                        {{-- <form class="step-form" id="step3Form">
                            @csrf
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
    $(document).ready(function() {
        // $('.otpstr').on('keyup', function() {
        //     $("#wrongotp").hide();
        //     let otp = "";
        //     inputs.forEach((input) => {
        //         otp += input.value;
        //     });
        //     console.log(inputs);
        //     let otpLength = (otp).length;
        //     if (otpLength === 6) {
        //         $("#otpprocess").show();
        //         $("#resendotp").hide();
        //         $.ajax({
        //             url: '/cx-otp-verification',
        //             type: 'post',
        //             data: 'otp=' + otp + '&cxslug={{ $cxSlug }}' +
        //                 '&_token={{ csrf_token() }}',
        //             success: function(data) {
        //                 if (data == 'success') {
        //                     window.location.href = "/cx-login-password-making/{{ $cxSlug }}/{{$flag}}";
        //                 } else {
        //                     $("#otpprocess").hide();
        //                     $("input").removeAttr("disabled").removeClass("disabled");
        //                     $("#wrongotp").show();
        //                     $("#resendotp").show();
        //                 }
        //             }
        //         });
        //     } else {
        //         console.log('please fill all four input');
        //     }

        // });

        const inputs = document.querySelectorAll('.otpstr');

        $('.otpstr').on('keyup', function() {
            let otp = Array.from(inputs).map(input => input.value).join('');
            $("#wrongotp").hide();

            if (otp.length === 6) {
                $("#otpprocess").show();
                $("#resendotp").hide();

                $.ajax({
                    url: '/cx-otp-verification',
                    type: 'post',
                    data: {
                        otp: otp,
                        cxslug: '{{ $cxSlug }}',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data === 'success') {
                            window.location.href = `/cx-login-password-making/{{ $cxSlug }}/{{ $flag }}`;
                        } else {
                            $("#otpprocess").hide();
                            $("#wrongotp").show();
                            $("#resendotp").show();
                        }
                    }
                });
            }
        });
        
        $('#resendotp').on('click', function() {
            let cxSlug = "{{ $cxSlug }}";
            $("#resendotp").hide();
            $("#otpprocess").text('Re-Sending OTP please wait');
            $("#otpprocess").show();
            $.ajax({
                url: '/cx-signup-resend-otp',
                type: 'post',
                data: 'cxslug=' + cxSlug + '&_token={{ csrf_token() }}',
                success: function(data) {
                    if (data == 'success') {
                        $("#otpprocess").text('OTP Sent! please enter');
                        $("#resendotp").show(5000);
                    } else {
                        console.log('Failed');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection

{{-- old ui --}}
{{-- @extends('Front/layout')
@section('page_title', 'Makita Customer | Customer SignUp OTP')
@section('cxsignup_select', 'active')
@section('container')
    <div class="container" style="margin-top: 60px !important;">
        <div class="row">
            <x-reachus />
            <div class="col-md-8">
                <p>OTP sent on +91 {{ Str::mask($mobile_number, '*', -9, 6) }} <a
                        href="{{ url('cx-signup') }}/{{ $cxSlug }}" title="Update Mobile Number">
                        <span class="glyphicon glyphicon-pencil pencil"></span></a> </p>
                <h2>Enter OTP</h2>
                <div class="otp-field">
                    <input class="otpstr" type="text" maxlength="1" />
                    <input class="otpstr" type="text" maxlength="1" />
                    <input class="otpstr space" type="text" maxlength="1" />
                    <input class="otpstr" type="text" maxlength="1" />
                    <input class="otpstr" type="text" maxlength="1" />
                    <input class="otpstr" type="text" maxlength="1" />
                </div>
                <p id="otpprocess" style="display: none;color:rgb(0, 134, 4);fot-size:20px">Please Wait While OTP Processing
                </p>
                <p id="wrongotp" style="display: none;color:red;fot-size:20px">You have entered wrong OTP</p>
                <p class="resendotp" id="resendotp" style="display: none">Resend OTP?</p>
                <div class="otptimer">Resend OTP in <span id="timer"></span> Seconds</div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('front_assets/script.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.otpstr').on('keyup', function() {
                    $("#wrongotp").hide();
                    let otp = "";
                    inputs.forEach((input) => {
                        otp += input.value;
                    });
                    let otpLength = (otp).length;
                    if (otpLength === 6) {
                        $("#otpprocess").show();
                        $("#resendotp").hide();
                        $.ajax({
                            url: '/cx-otp-verification',
                            type: 'post',
                            data: 'otp=' + otp + '&cxslug={{ $cxSlug }}' +
                                '&_token={{ csrf_token() }}',
                            success: function(data) {
                                if (data == 'success') {
                                    window.location.href = "/cx-login-password-making/{{ $cxSlug }}/{{$flag}}";
                                } else {
                                    $("#otpprocess").hide();
                                    $("input").removeAttr("disabled").removeClass("disabled");
                                    $("#wrongotp").show();
                                    $("#resendotp").show();
                                }
                            }
                        });
                    } else {
                        console.log('please fill all four input');
                    }

                });
                $('#resendotp').on('click', function() {
                    let cxSlug = "{{ $cxSlug }}";
                    $("#resendotp").hide();
                    $("#otpprocess").text('Re-Sending OTP please wait');
                    $("#otpprocess").show();
                    $.ajax({
                        url: '/cx-signup-resend-otp',
                        type: 'post',
                        data: 'cxslug=' + cxSlug + '&_token={{ csrf_token() }}',
                        success: function(data) {
                            if (data == 'success') {
                                $("#otpprocess").text('OTP Sent! please enter');
                                $("#resendotp").show(5000);
                            } else {
                                console.log('Failed');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection --}}


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
                                <div class="step-circle">3</div>
                                <div class="step-text">Password</div>
                            </div>
                            <div class="step">
                                <div class="step-circle active">4</div>
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
                        {{-- <form class="step-form active" id="step3Form" method="post" action="{{ route($route) }}">
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
                              </div>
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
                            @csrf
                            <input type="hidden" name="cxslug" value="{{ $cxslug }}" required>
                            <input type="hidden" name="flag" value="{{ $flag }}" required>
                            </div>
                            <button type="submit" class="btn-primary">Complete Registration</button>
                        </form> --}}

                        <form class="step-form active" id="step4Form" method="post" action="{{ route('cx-profile-manage') }}">
                            @csrf
                            <div class="f-col">
                              <div class="form-group">
                                  <label for="name">Full Name</label>
                                  <input type="text" id="name" placeholder="Enter your full name" value="{{ $name }}"  required>
                              </div>
                              <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" id="email" placeholder="Enter your email" value="{{ $email }}" required>
                              </div>
                            </div>
                            <div class="f-col">
                              <div class="form-group">
                                <label for="">State*</label>
                                <div class="custom-select-container" id="stateID">
                                      {{-- <input type="text" class="custom-select-input" readonly placeholder="Select an option..."> --}}
                                      {{-- <div class="dropdown-arrow"></div>
                                      <div class="custom-select-dropdown"> --}}
                                        <select class="form-control select2" name="state" style="width: 100%;" id="state"
                                        required>
                                        <option value="0">Please Select State</option>
                                        @foreach ($states as $stateList)
                                            <option @if ($stateList->id == $state_id) selected @endif value="{{ $stateList->id }}">
                                                {{ ucfirst(trans($stateList->name)) }}</option>
                                        @endforeach
                                        </select>
                                          {{-- <input type="text" class="search-box" placeholder="Type to search..."> --}}
                                          {{-- <div class="options-container"> --}}
                                            {{-- @foreach ($states as $stateList)
                                            <option @if ($stateList->id == $state_id) selected @endif value="{{ $stateList->id }}">
                                                {{ ucfirst(trans($stateList->name)) }}</option>
                                            @endforeach --}}
                                          {{-- </div> --}}
                                      {{-- </div> --}}
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="">City*</label>
                                <div class="custom-select-container" id="cityID">
                                    {{-- <input type="text" class="custom-select-input" readonly placeholder="Select an option..."> --}}
                                    {{-- <div class="dropdown-arrow"></div>
                                    <div class="custom-select-dropdown"> --}}
                                        <select class="form-control select2" name="city" style="width: 100%;" id="city">
                                            @if ($city_id != '')
                                                <option>Select A City</option>
                                                @foreach ($cityByState as $citiesbystateList)
                                                    <option @if ($citiesbystateList->id == $city_id) selected @endif
                                                        value="{{ $citiesbystateList->id }}">
                                                        {{ $citiesbystateList->name }}</option>
                                                @endforeach
                                                @else
                                                <option>Select A State To Fetch City</option>
                                            @endif
                                        </select>
                                        {{-- <input type="text" class="search-box" placeholder="Type to search..."> --}}
                                        {{-- <div class="options-container"> --}}
                                            {{-- @if ($city_id != '')
                                            <option>Select A City</option>
                                            @foreach ($cityByState as $citiesbystateList)
                                                <option @if ($citiesbystateList->id == $city_id) selected @endif
                                                    value="{{ $citiesbystateList->id }}">
                                                    {{ $citiesbystateList->name }}</option>
                                            @endforeach
                                            @else
                                            <option>Select A State To Fetch City</option>
                                            @endif --}}
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                              <label>Address</label>
                              <textarea placeholder="Enter your comment here" name="comment">{{ $address }}</textarea>
                              </div>
                            <button type="submit" class="btn-primary">Complete Registration</button>
                        </form>
            
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
    $('#state').on('change', function() {
        $('.ajax-loader').hide();
        $('.citymsg').text("Please wait while fetching Cities...").show();
        let stateID = $(this).val();
        $.ajax({
            url: '/city/get-cities-by-state',
            type: 'post',
            data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
            success: function(result) {
                $('.ajax-loader').show();
                $('.citymsg').hide();
                $('#city').html(result);
            }
        });
    });
});
$(function() {
    $('.select2').select2()
});
</script>
@endpush
@endsection




{{-- @extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('profile_select', 'active')
@section('container')
    <div id="contact" class="container">
        @push('styles')
            <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
        @endpush
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
            }
        </style>
        <div class="row">
            <x-reachus />
            <form method="post" action="{{ route('cx-profile-manage') }}">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sealerdealername">Name<span class="required">*</span></label>
                            <input class="form-control" id="name" name="name" placeholder="Enter Name"
                                value="{{ $name }}" type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="pop">Email</label>
                            <input class="form-control" id="email" name="email" placeholder="Enter Email"
                                value="{{ $email }}" type="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="sealerdealerstate">State<span class="required">*</span></label>
                            <select class="form-control select2" name="state" style="width: 100%;" id="state"
                                required>
                                <option value="0">Please Select State</option>
                                @foreach ($states as $stateList)
                                    <option @if ($stateList->id == $state_id) selected @endif value="{{ $stateList->id }}">
                                        {{ ucfirst(trans($stateList->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 form-group ajax-loader">
                            <label for="pop">City<span class="required">*</span></label>
                            <select class="form-control select2" name="city" style="width: 100%;" id="city">
                                @if ($city_id != '')
                                    <option>Select A City</option>
                                    @foreach ($cityByState as $citiesbystateList)
                                        <option @if ($citiesbystateList->id == $city_id) selected @endif
                                            value="{{ $citiesbystateList->id }}">
                                            {{ $citiesbystateList->name }}</option>
                                    @endforeach
                                    @else
                                    <option>Select A State To Fetch City</option>
                                @endif
                            </select>
                        </div>
                        <p class="citymsg" style="color: rgb(222 83 7 / 77%)"></p>
                    </div>
                    <textarea class="form-control" id="comments" name="address" placeholder="Enter Address" rows="5">{{ $address }}</textarea>
                    <br>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn pull-right" type="submit">Send</button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
        <br>
        <x-warrantypolicy />
    </div>
    @push('scripts')
        <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#state').on('change', function() {
                    $('.ajax-loader').hide();
                    $('.citymsg').text("Please wait while fetching Cities...").show();
                    let stateID = $(this).val();
                    $.ajax({
                        url: '/city/get-cities-by-state',
                        type: 'post',
                        data: 'stateID=' + stateID + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('.ajax-loader').show();
                            $('.citymsg').hide();
                            $('#city').html(result);
                        }
                    });
                });
            });
            $(function() {
                $('.select2').select2()
            });
        </script>
    @endpush
@endsection --}}

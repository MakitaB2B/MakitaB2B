@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer SignUp OTP')
@section('cxsignup_select', 'active')
@section('container')
    <!-- Container (Contact Section) -->
    <div class="container" style="margin-top: 60px !important;">
        <div class="row">
            <x-reachus />
            <div class="col-md-8">
                <p>OTP sent on +91 {{ Str::mask($mobile_number, '*', -9, 6) }} <a
                        href="{{ url('cx-signup') }}/{{ $cxSlug }}" title="Update Mobile Number">
                        <span class="glyphicon glyphicon-pencil pencil"></span></a> </p>
                <h2>Enter OTP  {{--{{ Crypt::decrypt($otp) }}--}} </h2>
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
        <!-- jQuery UI 1.11.4 -->
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
@endsection

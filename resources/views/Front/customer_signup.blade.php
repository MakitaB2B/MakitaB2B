@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer SignUp')
@section('cxsignup_select', 'active')
@section('container')
    <!-- Container (Contact Section) -->
    <div class="container" style="padding-top: 120px !important;">
        <div class="row">
            <x-reachus />
            <div class="col-md-8">
                <div class="wrapper">
                    <div class="box-wrapper">
                        <div class="box">
                            @if (session()->has('message'))
                                <h5 style="color:rgb(220, 2, 2)">{{ session('message') }}</h5>
                            @endif
                            <form id="form" action="{{ route('cx-signup-otp-send') }}" method="post">
                                @csrf
                                <div>
                                    <input type="text" name="mobile_number" value="{{ $mobile_number }}"
                                        title="Enter Valid Mobile Number" maxlength="10" pattern="[1-9]{1}[0-9]{9}"
                                        autocomplete="off" required placeholder="">
                                    <label>Enter Mobile Number</label>
                                </div>
                                @error('mobile_number')
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @enderror
                                <input id="submit" type="submit" value="Continue">
                                <input type="hidden" name="cxslug" value="{{ Crypt::encrypt($cxslug) }}">
                                <input type="hidden" name="forgetpassword" value="{{ $forgetpassword }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center" style="padding-top: 20px !important;">
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
            <h3>Steps Of Registration</h3>
            <div class="row">
                <div class="col-sm-4">
                    <a href="#demo" data-toggle="collapse">
                        <img src="https://placehold.co/100x100/008497/white?text=Mobile\nNumber" class="person"
                            alt="Enter Mobile Number" width="100" height="100">
                    </a>
                    <div id="demo" class="collapse">
                        <p>1. Enter Your Register Mobile Number.</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <a href="#demo2" data-toggle="collapse">
                        <img src="https://placehold.co/100x100/orange/white?text=OTP" class="person" alt="OTP"
                            width="100" height="100">
                    </a>
                    <div id="demo2" class="collapse">
                        <p>1. Receive the OTP on your mobile </p>
                        <p>2. Enter the correct OTP & Submit </p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <a href="#demo3" data-toggle="collapse">
                        <img src="https://placehold.co/100x100/ED1B24/white?text=Your\nDetails" class="person"
                            alt="Personal Details" width="100" height="100">
                    </a>
                    <div id="demo3" class="collapse">
                        <p>1. Enter some of your details like Name, Email ID, etc.</p>
                        <p>2. You are authorized to access the dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

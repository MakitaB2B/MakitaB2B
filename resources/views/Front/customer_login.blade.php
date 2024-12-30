@extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@push('styles')
<style>
    .errormsg{
        width: 120px;
        text-align: center;
        background: #ef3139;
        border-radius: 1.5px;
    }
    .white{
        color: #fff;
    }
    .heading{
        width: 100px;
        text-align: center;
        background: #1990a1;
        border-radius: 1.5px;
        color: #fff;
        margin-top:3px;
        cursor: pointer;
    }
    .bxshadow{
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    .lrtag{
        color: #1990a1;
        font-size: 11px;
        font-weight: 600;
    }
    .font10{
        font-size: 10px;
    }
</style>
@endpush
@section('container')
        <main class="main-content bg-grey">
            <div class="container">
                <div class="content">
                    <div class="left-side">
                            <!-- <div class="carousel-container">
                                <div class="carousel">
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 1">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 2">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="./img/hero-.jpg" alt="Slide 3">
                                    </div>
                                </div>
                                
                                <button class="carousel-btn prev-btn">❮</button>
                                <button class="carousel-btn next-btn">❯</button>
                                
                                <div class="carousel-indicators"></div>
                            </div> -->
                        <div class="content-info">                            
                            <div class="card-container">
                                    <!-- <h1 class="title">WARRANTY SERVICE STEPS</h1> -->
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
                                          <h2 class="step-title">Login | Register</h2>
                                          <p class="step-description">Create your account or sign in to access warranty services and track your claims.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">02</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <circle cx="11" cy="11" r="8"></circle>
                                              <path d="m21 21-4.3-4.3"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Search Product</h2>
                                          <p class="step-description">Locate your product using the serial number, model name, or purchase details.</p>
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
                                          <h2 class="step-title">Fill Details</h2>
                                          <p class="step-description">Provide the required information about your warranty claim and issue details.</p>
                                        </div>
                                      </div>
                                
                                      <div class="step-card">
                                        <div class="step-number">04</div>
                                        <div class="step-content">
                                          <div class="step-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M20 6L9 17l-5-5"></path>
                                            </svg>
                                          </div>
                                          <h2 class="step-title">Review & Submit</h2>
                                          <p class="step-description">Verify all information and submit your warranty request for processing.</p>
                                        </div>
                                      </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="card-s">
                            <div class="auth-container" id="loginPage">
                                <div class="auth-header">
                                    <h1>Welcome Back</h1>
                                    <p>Please login to your account</p>
                                    @if (session()->has('error'))
                                    <div class="card card-danger shadow" style="margin-bottom:20px!important">
                                        <div class="card-header errormsg">
                                            <p class="card-title white font10">{{ session('error') }}</p>
                                        </div>
                                    </div>
                                    @elseif (session()->has('message'))
                                            <div class="card card-danger shadow" style="margin-bottom:20px!important;background:#3b9900;text-align: center;border-radius: 1.5px;">
                                                <div class="card-header">
                                                    <p class="card-title white font10">{{ session('message') }}</p>
                                                </div>
                                            </div>
                                    @endif
                                </div>
                                <form id="loginForm" method="post" action="{{ route('cx-login-credentials-process') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="loginNumber">Mobile Number</label>
                                        <input type="text"  class="form-control" id="loginNumber" name="user_id" placeholder="Enter your number" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="loginPassword">Password</label>
                                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required autocomplete="off">  
                                    </div>
                                    <button type="submit" class="btn-primary submit-button">Login</button>
                                    <div class="auth-links">
                                        <a href="{{ url('cx-signup/'.Crypt::encrypt(0).'/') }}">Don't have an account? Register</a>
                                        <a href="{{ url('cx-signup/'.Crypt::encrypt(0).'/'.Crypt::encrypt(1)) }}">Forgot Password?</a>
                                    </div>
                                    <div class="contact-info">
                                        <p>Need help? Contact us at:</p>
                                        <div class="contact-details">
                                            <p><span>📍 Reach us at</span> :  Bangalore, India</p>
                                            <p><span>📞 Call us at</span> :  +91-80-2205-8200</p>
                                            <p><span>✉️ Contact us at</span> : <a href="mailto:sales@makita.in">sales@makita.in</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
























{{-- old ui --}}

{{-- @extends('Front/layout')
@section('page_title', 'Makita Customer | Customer Details')
@section('cxsignup_select', 'active')
@section('container')
<style>
    .errormsg{
        width: 120px;
        text-align: center;
        background: #ef3139;
        border-radius: 1.5px;
    }
    .white{
        color: #fff;
    }
    .heading{
        width: 100px;
        text-align: center;
        background: #1990a1;
        border-radius: 1.5px;
        color: #fff;
        margin-top:3px;
        cursor: pointer;
    }
    .bxshadow{
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    .lrtag{
        color: #1990a1;
        font-size: 11px;
        font-weight: 600;
    }
    .font10{
        font-size: 10px;
    }
</style>
    <div id="contact" class="container">
        <div class="row">
            <x-reachus />
            <div class="col-md-8 bxshadow">
            <p class="heading">Login</p>
            @if (session()->has('error'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important">
                        <div class="card-header errormsg">
                            <p class="card-title white font10">{{ session('error') }}</p>
                        </div>
                    </div>
            @elseif (session()->has('message'))
                    <div class="card card-danger shadow" style="margin-bottom:20px!important;background:#3b9900;text-align: center;border-radius: 1.5px;">
                        <div class="card-header">
                            <p class="card-title white font10">{{ session('message') }}</p>
                        </div>
                    </div>
            @endif
            <form method="post" action="{{ route('cx-login-credentials-process') }}">
                    <div class="row">
                        <div class="col-sm-7 form-group">
                            <label for="userid">Registered Mobile Number<span class="required">*</span></label>
                            <input class="form-control"  name="user_id" placeholder="Registered Mobile Number"
                                type="text" required autocomplete="off">
                            @error('userid')
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible show">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-7 form-group">
                            <label for="password">Password<span class="required">*</span></label>
                            <input class="form-control" name="password"
                                placeholder="Enter Password" type="password" required autocomplete="off">
                            <span id='message'></span>
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
                    <div class="row">
                        <div class="col-sm-7 form-group">
                            <button class="btn pull-right" type="submit" id="submitfrom">Send</button>
                            <a href="{{ url('cx-signup/'.Crypt::encrypt(0).'/'.Crypt::encrypt(1)) }}" class="lrtag">Forget Password?</a><br><br>
                            <a href="{{ url('cx-signup') }}" class="lrtag">Register Now?</a>
                        </div>
                    </div>
                @csrf
            </form>
        </div>
        </div>
    </div>
@endsection --}}

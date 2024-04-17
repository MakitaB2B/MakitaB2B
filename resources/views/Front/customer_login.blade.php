@extends('Front/layout')
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

    <!-- Container (Contact Section) -->
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
@endsection

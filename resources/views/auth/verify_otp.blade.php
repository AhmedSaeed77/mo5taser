@extends('site.includes.master')

@section('content')
    <!--========================== Start login page =============================-->
    <section class="login_page">
        <div class="container">
            <div class="form_modal wow animate__animated animate__fadeInUp">
                <div class="row no-gutters">
                    <div class="col-lg-7 o-2">
                        <form method="POST" action="{{ route('verify_otp') }}" class="form_box">
                            @csrf
                            <h5 class="head mb-30">@lang('lang.Verify OTP')</h5>
                            <p class="mb-20">@lang('lang.We have sent you a message contain otp code to verify your account')</p>
                            <div class="form-group">
                                <div class="input_form">
                                    <span class="icon"><i class="la la-key"></i></span>
                                    <input type="text" class="form-control" name="otp" placeholder="@lang('lang.OTP')" required autofocus>
                                </div>
                            </div>
                            <div class="form-group forget_pass">
                                <a href="{{ route('resend_verify_otp') }}">@lang('lang.Resend')</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="main-btn main">@lang('lang.send')</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="image h-100">
                            <img src="{{asset($image_control->image_login ?? 'site/images/login.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========================== End login page =============================-->

@endsection

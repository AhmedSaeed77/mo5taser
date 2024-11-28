@extends('site.includes.master')

@section('content')
    <!--========================== Start login page =============================-->
    <section class="login_page">
        <div class="container">
            <div class="form_modal wow animate__animated animate__fadeInUp">
                <div class="row no-gutters">
                    <div class="col-lg-7 o-2">
                        <form method="POST" action="{{ route('reset_password_otp') }}" class="form_box">
                            @csrf
                            <h5 class="head mb-30">@lang('lang.Reset Password')</h5>
                            <p class="mb-20">@lang('lang.Add your phone number to send you an OTP')</p>
                            <div class="form-group">
                                <div class="input_form">
                                    <span class="icon"><i class="las la-phone-volume"></i></span>
                                    <input type="tel" name="phone" class="form-control wizard-required" style="direction: ltr !important;" placeholder="966XXXXXXXXXX" value="{{old('phone')}}" autofocus>
                                    <div class="wizard-form-error"></div>
                                </div>
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

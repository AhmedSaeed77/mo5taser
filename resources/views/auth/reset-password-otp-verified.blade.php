@extends('site.includes.master')

@section('content')
    <!--========================== Start login page =============================-->
    <section class="login_page">
        <div class="container">
            <div class="form_modal wow animate__animated animate__fadeInUp">
                <div class="row no-gutters">
                    <div class="col-lg-7 o-2">
                        <form method="POST" action="{{ route('reset_password_otp_verified', $token) }}" class="form_box">
                            @csrf
                            <h5 class="head mb-30">@lang('lang.Reset Password')</h5>
                            <p class="mb-20">@lang('lang.Reset code is right enter new password')</p>
                            <input name="token" type="hidden" value="{{$token}}">
                            <div class="form-group">
                                <label for="">@lang('lang.password')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="la la-lock"></i></span>
                                    <input type="password" class="form-control wizard-required" name="password" placeholder="@lang('lang.password')" id="password-field">
                                    <span toggle="#password-field" class="fa toggle-password fa-eye"></span>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('lang.confirm_password')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="la la-lock"></i></span>
                                    <input type="password" class="form-control wizard-required" name="password_confirmation" placeholder="@lang('lang.confirm_password')" id="password-field_2">
                                    <span toggle="#password-field_2" class="fa toggle-password fa-eye"></span>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                            <div class="form-group forget_pass">
                                <a href="{{ route('reset_password') }}">@lang('lang.Resend')</a>
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

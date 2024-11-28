@extends('site.includes.master')

@section('content')
<!--========================== Start login page =============================-->
    <section class="login_page">
        <div class="container">
            <div class="form_modal wow animate__animated animate__fadeInUp">
                <div class="row no-gutters">
                    <div class="col-lg-7 o-2">
                        <form method="POST" action="{{ route('login') }}" class="form_box">
                            @csrf
                            <h5 class="head mb-30">@lang('lang.login')</h5>
                            <div class="form-group">
                                <label for="">@lang('lang.email')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="la la-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('lang.password')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="las la-lock"></i></span>
                                    <div class="pass-group">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                        <span toggle="#password" class="fa toggle-password fa-eye"></span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group forget_pass">
                                <a href="{{ route('reset_password') }}">@lang('lang.forget_password')</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="main-btn main">@lang('lang.login')</button>
                                <div class="no_account flex_center">
                                    <p class="m-0">@lang('lang.do_not_have_account')</p>
                                    <a href="{{route('register')}}">@lang('lang.register')</a>
                                </div>
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

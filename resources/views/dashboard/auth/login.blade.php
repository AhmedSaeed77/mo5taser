<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <link rel="shortcut icon" href="{{asset('dashboard/images/fav.png')}}">
        <title>@lang('lang.login_admin')</title>

        <link href="{{asset('dashboard/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

        <script src="{{asset('dashboard/js/modernizr.min.js')}}"></script>

    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading">
                <h3 class="text-center">@lang('lang.login_admin')</h3>
            </div>


            <div class="panel-body">
                <form class="form-horizontal m-t-20" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="form-group">
                        <label for="">@lang('lang.email')</label>
                        <input type="email" placeholder="Example@example.com" class="form-control"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    </div>
                    <div class="form-group">
                        <label for="">@lang('lang.password')</label>
                        <div class="pass-group">
                            <input type="password" placeholder="@lang('lang.password')" class="form-control" name="password" required autocomplete="current-password" id="password-field">
                            <span toggle="#password-field" class="toggle-password fal fa-lock-open-alt"></span>

                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">@lang('lang.login')</button>
                    </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                    </div>
                </div>
            </form>

            </div>
            </div>
                <div class="row">
            	<div class="col-sm-12 text-center">
                </div>
            </div>

        </div>
        <script src="{{asset('dashboard/js/jquery.min.js')}}"></script>
        @include('shared.toastr')

	</body>
</html>

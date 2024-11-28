<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" type="image/x-icon" href="{{asset($image_control->image_fav ?? 'site/images/fav.png')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@lang('lang.project_name')</title>

        <!--Morris Chart CSS -->
        @yield('css')
        <link rel="stylesheet" href="{{asset('dashboard/plugins/magnific-popup/css/magnific-popup.css')}}"/>
		<link rel="stylesheet" href="{{asset('dashboard/plugins/morris/morris.css')}}">
        <link href="{{asset('dashboard/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
        <link href="{{asset('dashboard/css/custom.css')}}" rel="stylesheet" type="text/css" />

        @if (App::isLocale('en'))
        <!-- ltr style -->
        <link href="{{asset('dashboard/css/core-ltr.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('dashboard/css/responsive-ltr.css')}}" rel="stylesheet">
        <link href="{{asset('dashboard/css/customltr.css')}}" rel="stylesheet" type="text/css" />

        @endif
        @yield('style')

        <script src="{{asset('dashboard/js/modernizr.min.js')}}"></script>

    </head>


    <body class="fixed-left">
            <div id="wrapper">

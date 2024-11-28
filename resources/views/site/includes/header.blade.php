<!DOCTYPE html>
<html>

<head>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta name="author" content="Arboon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0D3558">
    <meta name="google-site-verification" content="rHSUlqNmHV9ajD6OPh6wLXvyvlePIvsGP29WqZ2cVOY" />
    <title>@lang('lang.project_name')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset($image_control->image_fav ?? 'site/images/fav.png')}}" />

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('site/css/vendor.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/plyr.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/jquery.popup.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/style.css')}}" />


    <style type="text/css">
        .custom-pop {
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-70%, -60%);
            width: 1000px;
            height: 500px;
            text-align: center;
            background-color: #e8eae6;
            box-sizing: border-box;
            z-index: 100;
            display: none;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            padding: 4px;
            cursor: pointer;
        }
    </style>


    @if (App::isLocale('en'))
        <link rel="stylesheet" href="{{asset('site/css/style-en.css')}}" />
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    @yield('css')
</head>

<body class="intro">

    <!--========================== Start second nav =============================-->
    <nav class="second_nav {{request()->segment(1) == '' ? 'in_home' : ''}} {{request()->segment(1) == 'login' ? 'login_nav' : ''}} {{request()->segment(1) == 'register' ? 'login_nav' : ''}}">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-5">
                    <a href="{{route('home')}}" class="logo">

                        @if(request()->segment(1) != '')
                          <img src="{{asset($image_control->image_top_logo ?? 'site/images/logo_white.png')}}" alt="#" />
                          {{--  <img src="{{asset('site/images/logo_white.png')}}" alt="#" />  --}}
                          @else
                          <img src="{{(request()->segment(1) != '' ? asset($image_control->image_top_logo) : asset($image_control->image_footer_logo)) ?? asset('site/images/logo_white.png')}}" alt="#" />
                          {{--  <img src="{{asset('site/images/logo.png')}}" alt="#" />  --}}
                        @endif
                    </a>
                </div>
                <div class="col-lg-6 center_div d-lg-flex d-none">
                    <div class="list_menu">
                        <ul class="main_list">
                            @php
                              $categories = \App\Models\Category::category('course')->with('courses')->get();
                            @endphp
                            @if($categories->count() > 0)
                            <li>
                                <a href="{{route('courses')}}" class="onceClick">
                                    <span>@lang('lang.training_courses')</span>
                                    <i class="fas fa-chevron-down"></i>
                                </a>
                                <div class="dropdown_menu">
                                    <ul>
                                        @foreach ($categories as $key => $category)
                                            <li>
                                                <a href="#">
                                                    <span>{{$category->title}}</span>
                                                    <i class="fas fa-chevron-down"></i>
                                                </a>
                                                <div class="dropdown_menu">
                                                    <ul>
                                                        @foreach ($category->courses as $item)
                                                        <li>
                                                            <a href="{{route('course.show',$item->id)}}">{{$item->title}}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @php
                                    $courses = \App\Models\Course::get();
                                @endphp
                                @if ($courses->count() > 0)
                                    <!--<div class="dropdown_menu">-->
                                    <!--    <ul>-->
                                    <!--        @foreach ($courses as $course)-->
                                    <!--            <li><a href="{{route('course.show',$course->id)}}">{{$course->title}}</a></li>-->
                                    <!--        @endforeach-->
                                    <!--    </ul>-->
                                    <!--</div>-->
                                @endif
                            </li>
                            @endif
                            <li><a href="{{route('exams')}}" class="onceClick">@lang('lang.general_exams')</a></li>
                            <li><a href="{{route('assemblies')}}" class="onceClick">@lang('lang.assemblies')</a></li>
                            <li><a href="{{route('site_store')}}" class="onceClick">@lang('lang.store')</a></li>
                        </ul>
                    </div>
                    <form action="{{route('search')}}" class="search_box" method="GET">
                        @method('GET')
                        <input type="text" name="search" value="{{request()->search ?? ''}}"
                        placeholder="@lang('lang.search_in_courses')" class="form-control" required>
                        <button class="icon border-0"><i class="la la-search"></i></button>
                    </form>
                </div>
                <div class="col-lg-3 col-7 d-lg-flex d-none flex-end">
                    <div class="settings">
                        @if(auth()->check())
                        @php
                            $carts = \App\Models\Cart::where('user_id',auth()->id())->get();
                        @endphp
                        <div class="icons">
                            <!--<span class="icon d-flex d-lg-none" id="icon_search">-->
                            <!--    <i class="la la-search"></i>-->
                            <!--</span>-->
                            <div class="login_box">
                                <span class="icon">
                                    <i class="la la-user"></i>
                                    <span class="active"></span>
                                </span>
                                <ul class="dropdown_menu">
                                    <li>
                                        <a href="#">
                                            <i class="las la-user-cog"></i>
                                            <span>{{auth()->user()->name}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <i class="las la-user-circle"></i>
                                            <span>@lang('lang.profile')</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('account')}}">
                                            <i class="las la-user"></i>
                                            <span>@lang('lang.personal_account')</span>
                                        </a>
                                    </li>
                                    {{--  <li>
                                        <a href="#">
                                            <i class="la la-envelope"></i>
                                            <span>الرسائل</span>
                                        </a>
                                    </li>  --}}
                                    <li>
                                        <a href="{{route('logout')}}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            <i class="las la-sign-out-alt"></i>
                                            <span>@lang('lang.log_out')</span>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="login_box noti_box">
                                <span class="icon">
                                    <i class="las la-bell"></i>
                                    @if (Auth::user()->unReadNotifications()->get()->count() > 0)
                                    <span class="active">{{Auth::user()->unReadNotifications()->get()->count()}}</span>
                                    @endif
                                </span>
                                <ul class="dropdown_menu">
                                    @if (Auth::user()->unReadNotifications()->get()->count() > 0)
                                        @foreach (Auth::user()->unReadNotifications()->take(4)->get() as $not)
                                            @if ($not->type == 'App\Notifications\GetCertificateUser')
                                                <li>
                                                    <a href="{{route('profile')}}">
                                                        <span class="text">@lang('lang.get_certificate')</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($not->type == 'App\Notifications\removeCertificateUser')
                                                <li>
                                                    <a href="{{route('profile')}}">
                                                        <span class="text">@lang('lang.remove_certificate')</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($not->type == 'App\Notifications\activeSubscribtion')
                                                <li>
                                                    <a href="{{route('my-courses')}}">
                                                        <span class="text">@lang('lang.activeSubscribtion')</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($not->type == 'App\Notifications\unActiveSubscribtion')
                                                <li>
                                                    <a href="{{route('my-courses')}}">
                                                        <span class="text">@lang('lang.unActiveSubscribtion')</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($not->type == 'App\Notifications\StudentTestCorrection')
                                                <li>
                                                    <a href="{{route('exam-attempts-site', $not->data['id'])}}">
                                                        <span class="text">@lang('lang.you passed exam')</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach

                                    @else
                                    <a href="#" class="all_noti">@lang('lang.no_unread_notifications')</a>
                                    @endif
                                    <a href="{{route('notifications')}}" class="all_noti">@lang('lang.all_notifications') </a>
                                </ul>
                            </div>
                            <div class="minicart_wrapper cart_content">

                                <span href="#" class="icon icon_cart">
                                    <i class="la la-shopping-cart"></i>
                                    <span class="active">{{$carts->count() > 0 ? $carts->count() : ''}}</span>
                                </span>
                                <div class="cart_content2">
                                    @if ($carts->count() > 0)
                                    <div class="minicartBox ">
                                        <h5>@lang('lang.courses_numbers')<strong> {{$carts->count() > 0 ? $carts->count() : ''}} </strong> <span class="btn_close" style="cursor: pointer;">X</span></h5>
                                        <hr>
                                        <div class="cart-details">
                                            <div class="">
                                                <div class="DEFAULT " id="cart_content2">
                                                    @foreach ($carts as $item)
                                                        <div class="row">
                                                                <div class="col-3 pr-0 product-image"><img class="img-fluid" src="{{asset($item->course->image)}}"></div>
                                                                <div class="col-9">
                                                                    <h6 class="product-name">{{$item->course->title}}</h6>
                                                                    <div class="product-pricing"></div>
                                                                    <div class="product-pricing"><strong class="price-container">@lang('lang.rs') {{$item->price}}</strong></div>
                                                                    {{--  <span class="remove " data-id="{{$item['id']}}">
                                                                        <button class="remove_from_cart" data-id="{{$item['id']}}">حذف</button>
                                                                    </span>  --}}
                                                                </div>
                                                                <div class="col-12">
                                                                    <hr>
                                                                </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="subtotal row pb-3">
                                            <div class="col-6">@lang('lang.total')</div>
                                            <div class="col-6 text-left"><strong>{{array_sum($carts->pluck('price')->toArray())}} @lang('lang.rs')</strong></div>
                                        </div>
                                        <div class="actions row">
                                            <div class="col-12 text-right"><a class="btn btn-primary checkout white" href="{{route('checkout')}}">@lang('lang.shopping_cart')</a></div>
                                        </div>
                                    </div>
                                    @else
                                        <div class="minicartBox">
                                            <div class="alert alert-danger text-center">
                                                <b>@lang('lang.cart_empty')</b>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                            <a href="{{route('login')}}" class="main-btn main onceClick">
                                <i class="las la-user-cog"></i>
                                <span>@lang('lang.login')</span>
                            </a>
                        @endif
                        @if (App::isLocale('ar'))
                            <a href="{{ url('/') }}/lang/en" class="lang">
                                <span>English</span>
                                <i class="fal fa-globe"></i>
                            </a>
                        @else
                            <a href="{{ url('/') }}/lang/ar" class="lang">
                                <span>عربي</span>
                                <i class="fal fa-globe"></i>
                            </a>
                        @endif

                    </div>
                </div>
                <div class="col-7 d-lg-none d-flex setting_mobile">
                    @if(auth()->check())
                        @php
                            $carts = \App\Models\Cart::where('user_id',auth()->id())->get();
                        @endphp
                <div class="minicart_wrapper cart_content">
                    <span href="#" class="icon icon_cart">
                        <i class="la la-shopping-cart"></i>
                        <span class="active">{{$carts->count() > 0 ? $carts->count() : ''}}</span>
                    </span>
                    <div class="cart_content2">
                        @if ($carts->count() > 0)
                        <div class="minicartBox ">
                            <h5>@lang('lang.courses_numbers')<strong> {{$carts->count() > 0 ? $carts->count() : ''}} </strong> <span class="btn_close" style="cursor: pointer;">X</span></h5>
                            <hr>
                            <div class="cart-details">
                                <div class="">
                                    <div class="DEFAULT " id="cart_content2">
                                        @foreach ($carts as $item)
                                            <div class="row">
                                                <div class="col-3 pr-0 product-image"><img class="img-fluid" src="{{asset($item->course->image)}}"></div>
                                                <div class="col-9">
                                                    <h6 class="product-name">{{$item->course->title}}</h6>
                                                    <div class="product-pricing"></div>
                                                    <div class="product-pricing"><strong class="price-container">@lang('lang.rs') {{$item->price}}</strong></div>
                                                    {{--  <span class="remove " data-id="{{$item['id']}}">
                                                        <button class="remove_from_cart" data-id="{{$item['id']}}">حذف</button>
                                                    </span>  --}}
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="subtotal row pb-3">
                                <div class="col-6">@lang('lang.total')</div>
                                <div class="col-6 text-left"><strong>{{array_sum($carts->pluck('price')->toArray())}} @lang('lang.rs')</strong></div>
                            </div>
                            <div class="actions row">
                                <div class="col-12 text-right"><a class="btn btn-primary checkout white" href="{{route('checkout')}}">@lang('lang.shopping_cart')</a></div>
                            </div>
                        </div>
                        @else
                            <div class="minicartBox">
                                <div class="alert alert-danger text-center">
                                    <b>@lang('lang.cart_empty')</b>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
                    <span class="search_icon" id="icon_search">
                        <i class="la la-search"></i>
                    </span>
                    <span class="toggle_icon">
                        <i class="las la-bars"></i>
                    </span>
                </div>
            </div>
        </div>
    </nav>
    <!--========================== End second nav =============================-->

    <!--========================== mobile list =============================-->
    <div class="mobile_list">
        <div class="top_div">
            @if(auth()->check())
            <div class="icons">
                <div class="login_box">
                    <span class="icon">
                        <i class="la la-user"></i>
                        <span class="active"></span>
                    </span>
                    <ul class="dropdown_menu">
                        <li>
                            <a href="#">
                                <i class="las la-user-cog"></i>
                                <span>{{auth()->user()->name}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('profile')}}">
                                <i class="las la-user-cog"></i>
                                <span>@lang('lang.profile')</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('account')}}">
                                <i class="las la-user-cog"></i>
                                <span>@lang('lang.personal_account')</span>
                            </a>
                        </li>
                        {{--  <li>
                            <a href="#">
                                <i class="la la-envelope"></i>
                                <span>الرسائل</span>
                            </a>
                        </li>  --}}
                        <li>
                            <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="las la-sign-out-alt"></i>
                                <span>@lang('lang.log_out')</span>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="login_box noti_box">
                    <span class="icon">
                        <i class="las la-bell"></i>
                        <span class="active"></span>
                    </span>
                    <ul class="dropdown_menu">
                        @if (Auth::user()->unReadNotifications()->get()->count() > 0)
                            @foreach (Auth::user()->unReadNotifications()->take(4)->get() as $not)
                                @if ($not->type == 'App\Notifications\GetCertificateUser')
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <span class="text">@lang('lang.get_certificate')</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($not->type == 'App\Notifications\removeCertificateUser')
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <span class="text">@lang('lang.remove_certificate')</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($not->type == 'App\Notifications\StudentPassContest')
                                    <li>
                                        <a href="{{route('attempts.result', $not->data['id'])}}">
                                            <span class="text">@lang('lang.you passed exam')</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($not->type == 'App\Notifications\StudentTestCorrection')
                                    <li>
                                        <a href="{{route('exam-attempts-site', $not->data['id'])}}">
                                            <span class="text">@lang('lang.you passed exam')</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                        @else
                        <a href="#" class="all_noti">@lang('lang.no_unread_notifications')</a>
                        @endif
                        <a href="{{route('notifications')}}" class="all_noti">@lang('lang.all_notifications') </a>
                    </ul>
                </div>

            </div>
            @else
            <a href="{{route('login')}}" class="main-btn main onceClick">
                <i class="las la-user-cog"></i>
                <span>@lang('lang.login')</span>
            </a>
            @endif
            @if (App::isLocale('ar'))
                <a href="{{ url('/') }}/lang/en" class="lang">
                    <span>English</span>
                    <i class="fal fa-globe"></i>
                </a>
            @else
                <a href="{{ url('/') }}/lang/ar" class="lang">
                    <span>عربي</span>
                    <i class="fal fa-globe"></i>
                </a>
            @endif
        </div>
        <div class="list_menu">
            <ul>
                <li class="dropdown_item">
                    <span class="link_style flex-center-h">
                        <span>@lang('lang.courses')</span>
                        <i class="far fa-chevron-down"></i>
                    </span>
                    <ul class="dropdown_menu">
                        @php
                            $courses = \App\Models\Course::get();
                        @endphp
                        @if ($courses->count() > 0)
                            @foreach ($courses as $course)
                                <li>
                                    <a href="{{route('course.show',$course->id)}}">
                                        {{$course->title}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li><a href="{{route('exams')}}" class="link_style">@lang('lang.general_exams')</a></li>
                <li><a href="{{route('assemblies')}}" class="link_style">@lang('lang.assemblies')</a></li>
                <li><a href="{{route('site_store')}}" class="link_style">@lang('lang.store')</a></li>
            </ul>
        </div>
    </div>
    <!--========================== mobile list =============================-->


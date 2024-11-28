@php use App\Models\Progress; @endphp
@php
    $main_progress = Progress::query()->where('user_id', auth()->id())->whereHas('content', function ($query) use ($course) {
                                        $query->where('course_id', $course->id);
                                        $query->whereNotIn('type',['section','lesson','attachement','unit']);
                                    })->orderByDesc('updated_at')->first();
@endphp
    <!DOCTYPE html>
<html>

<head>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta name="author" content="Arboon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0D3558">
    <title>@lang('lang.project_name')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('site/images/fav.png')}}" />

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('site/css/vendor.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/plyr.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/style.css')}}" />
    @if (App::isLocale('en'))
        <link rel="stylesheet" href="{{asset('site/css/style-en.css')}}" />
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    @yield('css')

</head>

<body class="intro">

<nav class="second_nav in_course">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-5">
                <a href="{{route('home')}}" class="logo">
                    <img src="{{asset($image_control->image_footer_logo ?? 'site/images/logo.png')}}" alt="#" />
                </a>
            </div>
            <div class="col-lg-4 d-lg-block d-none">
                <div class="search_box">
                    <input type="text" placeholder="@lang('lang.search_in_courses')" class="form-control">
                    <span class="icon"><i class="la la-search"></i></span>
                </div>
            </div>
            <div class="col-lg-4 col-7">
                <div class="settings">
                    @if(auth()->check())
                        <div class="icons">
                        <span class="icon d-flex d-lg-none" id="icon_search">
                            <i class="la la-search"></i>
                        </span>
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
                                        @endforeach

                                    @else
                                        <a href="#" class="all_noti">@lang('lang.no_unread_notifications')</a>
                                    @endif
                                    <a href="{{route('notifications')}}" class="all_noti">@lang('lang.all_notifications') </a>
                                </ul>
                            </div>
                        </div>
                    @else
                        <a href="{{route('login')}}" class="main-btn main">
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
        </div>
    </div>
</nav>

<!--========================== Start single_course page =============================-->
<section class="single_course_join_page ">
    <div class="profile_list_side">
        <div class="person_name flex-center-h">
            <span class="icon flex-center"><i class="las la-user"></i></span>
            <h6 class="white-text m-0">{{auth()->user()->name}}</h6>
        </div>
        <ul class="list_control">
            <a href="{{route('home')}}" class="link">
                <i class="las la-home"></i>
                <span>@lang('lang.home')</span>
            </a>
            <a href="{{route('site.course-units',$course->id)}}" class="link">
                <i class="las la-list"></i>
                <span>@lang('lang.units')</span>
            </a>
            <li class="mou_tab active" data-content="course_section">
                <i class="las la-book-reader"></i>
                <span>@lang('lang.current_lesson')</span>
            </li>
            <li class="mou_tab" data-content="decisions_section">
                <i class="las la-clipboard-list"></i>
                <span>@lang('lang.lessons_course')</span>
            </li>
            <li class="mou_tab" data-content="table_section">
                <i class="las la-book-reader"></i>
                <span>@lang('lang.course_table')</span>
            </li>
            <li class="mou_tab" data-content="course_bag">
                <i class="las la-book-reader"></i>
                <span>@lang('lang.subscribed_course_bag')</span>
            </li>
            <li class="mou_tab" data-content="reports_section">
                <i class="fal fa-file-pdf"></i>
                <span>@lang('lang.attachements')</span>
            </li>
            @php
                $rate_user = \App\Models\Rating::where(['course_id'=>$course->id,'user_id' =>auth()->id()])->first();
            @endphp
            @if (!$rate_user)
                <li data-bs-toggle="modal" data-bs-target="#review_modal">
                    <i class="fal fa-star"></i>
                    <span>@lang('lang.add_rating')</span>
                </li>
            @endif
            @if ($course->course_group)

                <a href="{{$course->course_group}}" class="link">
                    <i class="fal fa-users"></i>
                    <span>@lang('lang.course_group')</span>
                </a>
            @endif
        </ul>
        <div class="apps_wrapper">
            <h6 class="text">@lang('lang.download_app')</h6>
            <a href="#"><img src="{{asset('site/images/app.png')}}" alt=""></a>
            <a href="#"><img src="{{asset('site/images/google.png')}}" alt=""></a>
        </div>
    </div>
    <div class="main_content">
        <h5 class="head_page flex-center-h mb-20">
            <i class="las la-book-reader main-color"></i>
            <span>@lang('lang.lessons') - {{$course->title}} -- ({{$unit->title}})</span>
        </h5>


        <div class="box_content" id="table_section">
            <div class="table_content book_pdf h-100 flex-center">
                {!! $course->course_table !!}
            </div>
        </div>

        <div class="box_content" id="course_bag">
            <div class="table_content book_pdf h-100 flex-center">
                {!! $course->subscribed_bag !!}
            </div>
        </div>

        <div class="box_content " id="reports_section">
            <div class="reports_content row">
                @if ($attachements->count() > 0)
                    @foreach ($attachements as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="box">
                                <div class="image"><img width="100" src="{{asset('site/images/icons/pdf.png')}}" alt=""></div>
                                <div class="info">
                                    <h6>{{$item->title}}</h6>
                                    <div class="meta">
                                        @if ($item->download == 1)
                                            <a href="{{asset($item->attachement)}}" class="main-btn main" download>@lang('lang.download')</a>
                                        @endif
                                        <a href="{{route('course-pdf',$item->id)}}" class="main-btn sec"  target="_blank">@lang('lang.show')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="alert alert-danger">
                                <strong><b>@lang('lang.no_attachments')</b></strong>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>



        <div class="box_content active" id="course_section">
            <div class="content_section">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="lessons_card">
                            @if ($sections->count() > 0)
                                @foreach ($sections as $key => $section)
                                    <div class="single_lesson_content" >
                                        <div class="head flex-center-h">
                                            <div class="flex-center-h">
                                                <i class="las la-clipboard-list"></i>
                                                <span>{{$section->title}}</span>
                                            </div>
                                            <span class="arrow"><i class="fal fa-chevron-down"></i></span>
                                        </div>
                                        @php
                                            $contents_lessons = \App\Models\Content::where('parent_id',$section->id)->where('type' , 'lesson')->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
                                        @endphp
                                        <div class="lessons_content" @if($main_progress !== null && $main_progress->content->parent->parent_id == $section->id) style="display: block;" @endif>
                                            @if($contents_lessons->count() > 0)
                                                <div class="child-h">
                                                    @foreach ($contents_lessons as $index => $contents_lesson)
                                                        <div class="item">
                                                            <div class="head flex-center-h">
                                                                <div class="flex-center-h">
                                                                    <i class="las la-clipboard-list"></i>
                                                                    <span>{{$contents_lesson->title}}</span>
                                                                </div>
                                                                <span class="arrow"><i class="fal fa-chevron-down "></i></span>
                                                            </div>
                                                            @php
                                                                $contents_section = \App\Models\Content::where('parent_id',$contents_lesson->id)->where('type','!=' , 'attachement')->orderBy('sort','asc')->get();
                                                            @endphp
                                                            @if($contents_section->count() > 0)
                                                                <div class="lessons_content" @if($main_progress !== null && $main_progress->content->parent_id == $contents_lesson->id) style="display: block;" @endif>

                                                                    @foreach ($contents_section as $key => $item)
                                                                        <a href="#" class="single_lesson flex-center-h content_link {{$main_progress !== null && $main_progress->content->id == $item->id ? 'active' : ''}}" data-id="{{$item->id}}">
                                                                <span class="icon_shape flex-center">
                                                                    @if($item->type == 'video')
                                                                        <i class="las la-play-circle"></i>
                                                                    @endif
                                                                    @if($item->type == 'homework' || $item->type == 'exam' || $item->type == 'split_test')
                                                                        <i class="las la-book"></i>
                                                                    @endif
                                                                    @if($item->type == 'zoom')
                                                                        <i class="las la-wifi"></i>
                                                                    @endif
                                                                    @if($item->type == 'note')
                                                                        <i class="las la-pen"></i>
                                                                    @endif
                                                                </span>
                                                                            <div class="info">
                                                                                <p class="m-0 text-ellipsis">{{$item->title}}  <span class="vimeo_duration" data-vimeo="{{$item->video_url}}"></span></p>
                                                                                @php
                                                                                    $progress = \App\Models\Progress::where(['user_id' => auth()->id() , 'content_id' => $item->id])->first();
                                                                                @endphp
                                                                                <span class="status icon_shape" id="check-{{ $item->id }}">
                                                                        @if ($progress)
                                                                                        <i class="fal fa-check"></i>
                                                                                    @else
                                                                                        <i class="fal fa-lock"></i>
                                                                                    @endif
                                                                    </span>
                                                                            </div>
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="main_content_wrapper">
                            @php

                                $content_first = \App\Models\Content::whereNotIn('type',['section','lesson','attachement','unit'])
                                ->where(['active' => 1 , 'course_id' => $course->id])->where(function ($query) use ($main_progress, $unit) {
                                    $query->whereHas('parent', function($query) use ($unit) {
                                        $query->whereHas('parent', function($query) use ($unit) {
                                            $query->whereHas('parent', function($query) use ($unit) {
                                                $query->where('id', $unit->id);
                                            });
                                        });
                                    });
                                    if ($main_progress !== null) {
                                        $query->where('contents.id', $main_progress->content_id);
                                    }
                                })->orderBy('parent_id', 'asc')->orderBy('sort','asc')->first();

                            @endphp
                            @if ($content_first)
                                @if($content_first->type == 'video')
                                    <div class="video_show">
                                        @if($content_first->video_platform == 'youtube')

                                            <div class="video_container">
                                                <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $content_first->video_id }}"></div>
                                            </div>

                                            <!--<iframe id="course_video_url" width="640" height="480"
                                                        src="https://www.youtube.com/embed/{{ $content_first->video_id }}?vq=hd720" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                                                        allowfullscreen></iframe>-->
                                        @elseif($content_first->video_platform == 'vimeo')


                                            <div class="video_container">
                                                <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $content_first->video_id }}"></div>
                                            </div>

                                            <!--<iframe id="course_video_url" data-id="{{$content_first->id}}"
                                                        src="https://player.vimeo.com/video/{{ $content_first->video_id }}?quality=720p"
                                                        width="640" height="480" frameborder="0"
                                                        allow="autoplay; fullscreen; picture-in-picture"
                                                        allowfullscreen></iframe>-->
                                        @endif
                                    </div>
                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                @endif
                                @if($content_first->type == 'note')
                                    <div class="box_design homework_show">
                                        <h6>{{$content_first->title}}</h6><br>
                                        <div class="alert alert-success text-center">
                                            <p>{{$content_first->desc}}</p>
                                        </div>
                                    </div>
                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                @endif
                                {{--  exam content  --}}
                                @if($content_first->type == 'exam')
                                    @php
                                        $questions_count = \App\Models\Question::where('content_id',$content_first->id)->get()->count();
                                    @endphp
                                    <div class="box_design homework_show">
                                        <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
                                        <h6>{{$content_first->title}}</h6>
                                        <p class="text">{!! $content_first->instructions !!}</p>
                                        <span class="time">@lang('lang.questions_number') <span> ( {{$content_first->questions_number}} )</span></span>
                                        <span class="time">@lang('lang.exam_time') <span> ( {{$content_first->exam_time}} )</span></span>


                                        @if ($content_first->getExamined() > 0)
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a href="{{route('exam-attempts-site',$content_first->id)}}" class="btn-form">
                                                        {{--  <strong>@lang('lang.finished_show_result')</strong>  --}}
                                                        <strong>@lang('lang.show_attempts')</strong>
                                                    </a>
                                                </div><br>
                                            </div>
                                        @endif
                                        @if ($content_first->getExamined() < $content_first->attempts_count)
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a href="{{route('course-exam',$content_first->id)}}" class="btn-form">@lang('lang.start_now')</a>
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                    <input type="hidden" id="content_id" value="{{$content_first->type}}">
                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                @endif


                                {{--  split exam  --}}
                                @if($content_first->type == 'split_test')
                                    @php
                                        $categories = \App\Models\ContentCategory::where('content_id',$content_first->id)->get();
                                        $questions_count = array_sum($categories->pluck('questions_number')->toArray());
                                        $questions_exist = \App\Models\Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get()->count();
                                    @endphp
                                    <div class="box_design homework_show">
                                        <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
                                        <h6>{{$content_first->title}}</h6>
                                        <p class="text">{!! $content_first->instructions !!}</p>
                                        @if($categories->count() > 0)
                                            <span class="time">@lang('lang.categories_count') <span> ( {{$categories->count()}} )</span></span>
                                            {{--  <span class="time">@lang('lang.exam_time') <span> ( {{$content_first->exam_time}} )</span></span>  --}}

                                            @if($questions_count == $questions_exist)

                                                @if ($content_first->getExamined() > 0)
                                                    <div class="col-md-12">
                                                        <div class="text-center">
                                                            <a href="{{route('exam-attempts-site',$content_first->id)}}" class="btn-form">
                                                                <strong>@lang('lang.show_attempts')</strong>
                                                            </a>
                                                        </div><br>
                                                    </div>
                                                @endif
                                                @if ($content_first->getExamined() < $content_first->attempts_count)
                                                    <div class="col-md-12">
                                                        <div class="text-center">
                                                            <a href="{{route('course-exam',$content_first->id)}}" class="btn-form">@lang('lang.start_now')</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-md-12">
                                                    <div class="text-center alert alert-danger">
                                                        <strong>@lang('lang.questions_not_exists')</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="col-md-12">
                                                <div class="text-center alert alert-danger">
                                                    <strong>@lang('lang.no_categories')</strong>
                                                </div>
                                            </div>

                                        @endif


                                    </div>
                                    <input type="hidden" id="content_id" value="{{$content_first->type}}">
                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                @endif

                                {{--  end split exam  --}}

                                {{--  homework content  --}}
                                @if($content_first->type == 'homework')
                                    @php
                                        $questions_count = \App\Models\Question::where('content_id',$content_first->id)->get()->count();
                                    @endphp
                                    <div class="box_design homework_show">
                                        <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
                                        <h6>{{$content_first->title}}</h6>
                                        <p class="text">{!! $content_first->instructions !!}</p>
                                        <span class="time">@lang('lang.questions_number') <span> ( {{$content_first->questions_number}} )</span></span>


                                        @if ($content_first->getExamined() > 0)
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a href="{{route('exam-attempts-site',$content_first->id)}}" class="btn-form">
                                                        {{--  <strong>@lang('lang.finished_show_result')</strong>  --}}
                                                        <strong>@lang('lang.show_attempts')</strong>
                                                    </a>
                                                </div><br>
                                            </div>
                                        @endif
                                        @if ($content_first->getExamined() < $content_first->attempts_count)
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a href="{{route('course-exam',$content_first->id)}}" class="btn-form">@lang('lang.start_now')</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" id="content_id" value="{{$content_first->type}}">
                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                @endif
                                @if($content_first->type == 'zoom')
                                    @php
                                        $zoom_date = Date('Y-m-d',strtotime($content_first->zoom_time));
                                        $zoom_time = Date('H:i:s',strtotime($content_first->zoom_time));
                                        $now_time = Date('H:i:s',strtotime(date("H:i:s")));

                                    @endphp
                                    @if ($content_first->recorded_url)
                                        <div class="video_show">

                                            @if($content_first->recorded_platform == 'youtube')
                                                <div class="video_container">
                                                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $content_first->recorded_id }}"></div>
                                                </div>


                                                <!--<iframe width="640" height="480"
                                                        src="https://www.youtube.com/embed/{{ $content_first->recorded_id }}?vq=hd720" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                                                        allowfullscreen></iframe>-->
                                            @elseif($content_first->recorded_platform == 'vimeo')


                                                <div class="video_container">
                                                    <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $content_first->recorded_id }}"></div>
                                                </div>

                                                <!--<iframe id="course_video_url" data-id="{{$content_first->id}}"
                                                        src="https://player.vimeo.com/video/{{ $content_first->recorded_id }}?quality=720p"
                                                        width="640" height="480" frameborder="0"
                                                        allow="autoplay; fullscreen; picture-in-picture"
                                                        allowfullscreen></iframe>-->
                                            @endif
                                            {{--                                                <iframe id="course_video_url"--}}
                                            {{--                                                    src="https://player.vimeo.com/video/{{ $content_first->recorded_url }}"--}}
                                            {{--                                                    width="640" height="480" frameborder="0"--}}
                                            {{--                                                    allow="autoplay; fullscreen; picture-in-picture"--}}
                                            {{--                                                    allowfullscreen></iframe>--}}
                                        </div>
                                        <input type="hidden" id="content_id" value="video">
                                        <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                    @else
                                        @if ($zoom_date >= date("Y-m-d"))
                                            @if ($zoom_date >= date("date('Y-m-d')") && ($zoom_time > $now_time))
                                                <div class="box_design zoom_show">
                                                    <div class="image"><img src="{{asset('site/images/Zoom-Logo.png')}}" alt=""></div>
                                                    <p class="text">{{$content_first->title}}</p>
                                                    <strong id="zoom_counter"
                                                            data-counter="{{ $content_first->zoom_time }}">{{$zoom_date}}
                                                    </strong>
                                                    <div class="text-center">
                                                        <a href="{{$content_first->live_url}}" class="btn-form d-none" id="zoom_meeting" data-id="{{$content_first->id}}" >@lang('lang.enter_meeting')</a>
                                                    </div>
                                                    <input type="hidden" id="content_id" value="{{$content_first->type}}">
                                                    <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                                    @else
                                                        <div class="alert alert-danger text-center">
                                                            <strong>@lang('lang.zoom_record_comming_soon')</strong>
                                                        </div>
                                                        <input type="hidden" id="content_id" value="{{$content_first->type}}">
                                                        <input type="hidden" id="progress_id" value="{{$content_first->id}}">
                                                    @endif
                                                    @else
                                                        <div class="alert alert-danger text-center">
                                                            <strong>@lang('lang.zoom_record_comming_soon')</strong>
                                                        </div>

                                                    @endif
                                                    @endif
                                                    @endif
                                                    @endif
                                                </div>

                                                @if($content_first)
                                                    @php
                                                        $comments = \App\Models\ContentComment::where(['content_id' => $content_first->id , 'parent_id' => NULL])->orderBy('id','desc')->get();
                                                    @endphp

                                                    <div class="comments-content">
                                                        <form action="#" class="comment-in mb-40">
                                                            <textarea class="form-control" placeholder="@lang('lang.comment')" id="comment_area"></textarea>
                                                            <button type="button" class="main-btn main border-0" id="btn_comment">@lang('lang.add_comment')</button>
                                                        </form>

                                                        <div id="content_comments">

                                                            @include('site.courses.single.comments')
                                                        </div>

                                                        <input type="hidden" id="active_content" value="{{$content_first->id}}">
                                                    </div>
                                                @endif
                        </div>
                    </div>
                </div>
            </div>



            <div class="box_content" id="decisions_section">
                <div class="section_content">
                    @if ($sections->count() > 0)
                        @foreach ($sections as $key => $section)
                            <div class="single_decision">
                                <div class="head flex-center-h flex-between">
                                    <h6 class="m-0">{{$section->title}}</h6>
                                    <span class="icon"><i class="las la-minus"></i></span>
                                </div>
                                @php
                                    $contents_lessons = \App\Models\Content::where('parent_id',$section->id)->where('type' , 'lesson')->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
                                @endphp
                                @if($contents_lessons->count() > 0)
                                    <div class="decision_content {{$key == 0 ? 'block' : ''}}" >
                                        @foreach ($contents_lessons as $index => $cont_lesson)
                                            <div class="single_decision">
                                                <div class="head flex-center-h flex-between">
                                                    <h6 class="m-0">{{$cont_lesson->title}}</h6>
                                                    <span class="icon"><i class="las la-minus"></i></span>
                                                </div>
                                                @php
                                                    $contents_section = \App\Models\Content::where('parent_id',$cont_lesson->id)->where('type','!=' , 'attachement')->orderBy('sort','asc')->get();
                                                @endphp
                                                @if($contents_section->count() > 0)
                                                    <div class="decision_content block" style="display: block;">
                                                        @foreach ($contents_section as $item)
                                                            <a href="#" class="item flex-center-h flex-between">
                                                                <div class="details_box flex-center-h">
                                                                    <div class="image">
                                                                        <img src="{{asset($course->image)}}" alt="">
                                                                        <span class="icon flex-center"><i class="las la-play-circle"></i></span>
                                                                    </div>
                                                                    <div class="info">
                                                                        <h6 class="name mb-10">{{$item->title}}</h6>
                                                                        @if ($item->type == 'zoom')
                                                                            <div class="meta flex-center-h">
                                                                                <span> @lang('lang.start_at') : {{$item->zoom_date}}</span>
                                                                                <span>{{date('h:i A', strtotime($item->zoom_time))}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $progress = \App\Models\Progress::where(['user_id' => auth()->id() , 'content_id' => $item->id])->first();
                                                                @endphp
                                                                <span class="status {{$progress ? 'finished' : ''}}">
                                                    @if ($progress)
                                                                        @lang('lang.finished')
                                                                    @else
                                                                        @lang('lang.comming')
                                                                    @endif
                                                </span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @endforeach
                                            </div>
                                            @endif
                                    </div>
                                    @endforeach
                                @endif


                            </div>
                </div>





            </div>
</section>
<!--========================== End single_course page =============================-->

@php
    $rate_user = \App\Models\Rating::where(['course_id'=>$course->id,'user_id' =>auth()->id()])->first();
@endphp
@if (!$rate_user)
    <div class="modal fade review_modal" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-head">
                    <h5>@lang('lang.course_rating')</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('course.rating')}}" method="POST" id="form_model" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <div class="rate">
                                <div class="rating-list">

                                    <input type="radio" name="rating" id="rate5{{$key}}" value="5" class="radio rating-radio rating-radio--5" >
                                    <label for="rate5{{$key}}" title="5 star rating" class="star-rating star-rating--5"></label>

                                    <input type="radio" name="rating" id="rate4{{$key}}" value="4" class="radio rating-radio rating-radio--4">
                                    <label for="rate4{{$key}}" title="4 star rating" class="star-rating star-rating--4"></label>

                                    <input type="radio" name="rating" id="rate3{{$key}}" value="3" class="radio rating-radio rating-radio--3">
                                    <label for="rate3{{$key}}" title="3 star rating" class="star-rating star-rating--3"></label>

                                    <input type="radio" name="rating" id="rate2{{$key}}" value="2" class="radio rating-radio rating-radio--2">
                                    <label for="rate2{{$key}}" title="2 star rating" class="star-rating star-rating--2"></label>

                                    <input type="radio" name="rating" id="rate1{{$key}}" value="1" class="radio rating-radio rating-radio--1" checked>
                                    <label for="rate1{{$key}}" title="1 star rating" class="star-rating star-rating--1"></label>

                                </div>
                                <input type="hidden" id="modal_data_id" value="">
                            </div>

                            <div class="form-group comment_box">
                                <label for="#">@lang('lang.add_comment')</label>
                                <textarea name="comment" class="form-control" style="height: 125px" required></textarea>
                            </div>
                            <input type="hidden" name="course_id" value="{{$course->id}}">
                            <div class="form-group mb-0 mt-20">
                                <button type="submit" class="main-btn sec border-0">@lang('lang.submit')</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endif

<script src="{{asset('site/vendor/js/jquery-1.11.0.min.js')}}"></script>
<script src="{{asset('site/vendor/js/bootstrap.min.js')}}"></script>
<script src="{{asset('site/vendor/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('site/vendor/js/wow.min.js')}}"></script>

<script src="{{asset('site/vendor/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('site/vendor/js/intlTelInput-jquery.min.js')}}"></script>
<script src="{{asset('site/vendor/js/jquery.sortable.min.js')}}"></script>
<script src="{{asset('site/vendor/js/venobox.min.js')}}"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script src="{{asset('site/vendor/js/jquery.lazyload.js')}}"></script>
<script class="" src="{{asset('site/js/plyr.js')}}"></script>
<script>

    $(window).on('load', () => {
        const players = Array.from(document.querySelectorAll('.playerH'));

        players.forEach(function(player) {
            player = new Plyr(player, {
                //debug:true,
                autoplay: false,
                ratio: '16:9',
                defaultQuality: '720',
                //   poster: "http://www.clair-obscur.ch/2004/images/PLEIX_Itsu.jpg"
            })
            var test = jQuery(player).attr('class');
            var container = jQuery(player.media).parents('.video_container');
            var image = container.attr('data-plyr-poster');

            window.addEventListener("load", function() {
                setTimeout(() => {
                    container.find('.plyr__poster').css({
                        'background-image':'url('+image+')'
                    });
                    container.css({opacity:1});
                }, 1000);
            })

            jQuery('.button').on('click',function(){
                player.pause();
            });
        });
    }) ;
    document.addEventListener('DOMContentLoaded', () => {




    });



    $('document').ready(function(){

        //$('.vimeo_duration').each(function(index, element) {
        //   var vimeo_id = $(this).data('vimeo')
        //console.log(vimeo_id)
        //  const options = {
        //      id: 567948578
        // };

        //  var vimeo_element =  $(this);

        //console.log(vimeo_element)

        ///  var vimeo_video = new Vimeo.Player(vimeo_element, options);

        //  vimeo_video.getDuration().then(function(duration) {
        //     console.log(duration);
        // }).catch(function(error) {
        //      console.log('error')
        // });
        //})
    });
</script>
<script src="{{asset('site/js/main.js')}}"></script>
@include('shared.toastr')
@yield('js')
@include('site.courses.single.single_course_js')

<script>
    $('#btn_comment').on('click', function(event) {
        var comment = $("#comment_area").val();
        var content_id = $('#active_content').val();
        if(comment)
        {
            $.ajax({
                url: "{{route('content-comment')}}",
                type: "POST",
                data: {
                    comment: comment,
                    content_id: content_id,
                    _token: '{!! csrf_token() !!}',
                },
                success: function(data) {

                    if(data[0] == 'added')
                    {
                        toastr.success({!! json_encode(Lang::get('lang.added')) !!});
                        $("#comment_area").val('')
                        $("#content_comments").empty();
                        $("#content_comments").append(data[1]);
                    }
                    else
                    {
                        toastr.error({!! json_encode(Lang::get('lang.not_found')) !!});
                    }
                },complete(data)
                {
                    $('.replaies-btn').on('click', function() {
                        $(this).parents('.single-comment').find('.replaies-comments').slideToggle();
                    })
                }
            });
        }
        else
        {
            toastr.error({!! json_encode(Lang::get('lang.add_comment_first')) !!});
        }
    });

    $('.btn_comment_reply').on('click', function(event) {

        var comment = $(this).prev().val();
        var parent_id = $(this).data('content');
        var content_id = $('#active_content').val();

        var btn = $(this);

        if(comment)
        {
            $.ajax({
                url: "{{route('content-comment-reply')}}",
                type: "POST",
                data: {
                    comment: comment,
                    parent_id: parent_id,
                    content_id: content_id,
                    _token: '{!! csrf_token() !!}',
                },
                success: function(data) {
                    if(data[0] == 'added')
                    {
                        toastr.success({!! json_encode(Lang::get('lang.added')) !!});
                        btn.prev().val('');
                        btn.parent().prev().empty();
                        btn.parent().prev().append(data[1]);
                    }
                    else
                    {
                        toastr.error({!! json_encode(Lang::get('lang.not_found')) !!});
                    }
                }
            });
        }
        else
        {
            toastr.error({!! json_encode(Lang::get('lang.add_comment_first')) !!});
        }

    });
</script>
</body>

</html>

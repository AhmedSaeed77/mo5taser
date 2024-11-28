@extends('site.includes.master')
@section('content')

    <div class="breadcrumbs wow animate__animated animate__fadeInUp">
        <div class="container">
            <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
            <span class="break">/</span>
            <a href="{{route('courses')}}" class="home">@lang('lang.courses')</a>
            <span class="break">/</span>
            <span class="current">{{$course->title}}</span>
        </div>
    </div>

    <!--========================== Start single_course page =============================-->
    <section class="single_course_page">
        <div class="container">
            <div class="row">
                <div class="col-12 wow animate__animated animate__fadeInUp">
                    <h3 class="course_name">{{$course->title}}</h3>
                </div>
                
                <div class="col-lg-9">
                    <div class="course_content">
                        <div class="course_video wow animate__animated animate__fadeInUp">
                            <!--<img src="{{asset($course->image)}}" alt="img">-->

                            @if($course->preview_video_platform == 'youtube')
                                <div class="video_container" data-plyr-poster="{{asset($course->image)}}">
                                    <div class="playerH" data-plyr-provider="youtube"
                                         data-plyr-embed-id="{{ $course->preview_video_id }}"></div>
                                </div>
                                <!--<a class="venobox play-btn vbox-item" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/embed/{{ $course->preview_video_id }}?vq=hd720"></a>-->
                            @elseif($course->preview_video_platform == 'vimeo')

                                <div class="video_container" data-plyr-poster="{{asset($course->image)}}">
                                    <div class="playerH" data-plyr-provider="vimeo"
                                         data-plyr-embed-id="{{ $course->preview_video_id }}"></div>
                                </div>
                                {{--                            <a class="venobox play-btn vbox-item" data-autoplay="true" data-vbtype="video" href="https://player.vimeo.com/video/{{ $course->preview_video_id }}?quality=720p"></a>--}}
                            @endif



                            @if($course->start_date)
                                @php
                                    $today = date('Y-m-d');
                                @endphp
                                @if($today < $course->start_date)
                                    <div class="countdown_box text-center">
                                        <p>@lang('lang.start_date')</p>
                                        <div class="countdown" data-count="{{$course->start_date}}">
                                            <div class="box">
                                                <span class="num">%D</span>
                                                <span class="name">@lang('lang.days')</span>
                                            </div>
                                            <div class="box">
                                                <span class="num">%H</span>
                                                <span class="name">@lang('lang.hours')</span>
                                            </div>
                                            <div class="box">
                                                <span class="num">%M</span>
                                                <span class="name">@lang('lang.mins')</span>
                                            </div>
                                            <div class="box">
                                                <span class="num">%S</span>
                                                <span class="name">@lang('lang.seconds')</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="about_course wow animate__animated animate__fadeInUp">
                            <div class="list_control">
                                <ul>
                                    <li class="mou_tab active"
                                        data-content="course_desceription">@lang('lang.description')</li>
                                    <li class="mou_tab" data-content="course_content">@lang('lang.course_content')</li>
                                    <li class="mou_tab" data-content="course_questions">@lang('lang.q_a')</li>
                                    @if ($ratings->count() > 0)
                                        <li class="mou_tab" data-content="course_rating">@lang('lang.ratings')</li>
                                    @endif
                                    {{--                                <li class="mou_tab" data-content="students_result">@lang('lang.students_results')</li>--}}
                                    <li class="mou_tab" data-content="course_bag">@lang('lang.course_bag')</li>
                                </ul>
                            </div>
                            <div class="main_content">
                                <div class="box_content active" id="course_desceription">
                                    <p class="desc">{!! $course->desc !!}</p>
                                </div>

                                <div class="box_content " id="course_content">
                                    @if($units->count() > 0)
                                        <div class="list_control">
                                            <ul>
                                                @foreach ($units as $key => $unit)
                                                    <li class="mou_tab {{$key == 0 ? 'active' : ''}}"
                                                        data-content="unit{{$key}}">{{$unit->title}}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @foreach ($units as $key => $unit)
                                            <div class="box_content {{$key == 0 ? 'active' : ''}}" id="unit{{$key}}">
                                                @php
                                                    $sections = \App\Models\Content::where('parent_id',$unit->id)->get();
                                                @endphp
                                                @if($sections->count() > 0)
                                                    @foreach ($sections as $key => $section)
                                                        @php
                                                            $contents_section = \App\Models\Content::where('parent_id',$section->id)->where('type','!=' , 'attachement')->get();
                                                        @endphp
                                                        <div class="course_block">
                                                            <div class="head">
                                                                <h6>{{$section->title}}</h6>
                                                                @if ($contents_section->count() > 0)
                                                                    <span>{{$contents_section->count()}} @lang('lang.lessons')</span>
                                                                @endif
                                                            </div>
                                                            <div class="content {{$key == 0 ? 'active' : ''}}">
                                                                @if ($contents_section->count() > 0)
                                                                    @foreach ($contents_section as $content_section)
                                                                        <a href="#" class="item" data-bs-toggle="modal"
                                                                           data-bs-target="#desc_modal">
                                                                            @if ($content_section->type == 'video')
                                                                                <div
                                                                                    class="video-item d-flex align-items-center"
                                                                                    style="justify-content: space-between; flex: 1;">
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-10">
                                                                                        <i class="las la-play-circle"></i>
                                                                                        <span
                                                                                            class="name">{{$content_section->title}}</span>
                                                                                    </div>
                                                                                    <span
                                                                                        class="video-time">12:20 min</span>
                                                                                </div>
                                                                            @else
                                                                                <i class="las la-file-alt"></i>
                                                                                <span
                                                                                    class="name">{{$content_section->title}}</span>
                                                                            @endif

                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach

                                    @endif

                                </div>

                                <div class="box_content " id="course_questions">
                                    @if ($course->questions()->get()->count() > 0)
                                        @foreach ($course->questions()->get() as $key => $question)
                                            <div class="course_block {{$key == 0 ? 'active' : ''}}">
                                                <div class="head">
                                                    <i class="las la-question-circle"></i>
                                                    <h6>{{$question->question}}</h6>
                                                </div>
                                                <div class="content">
                                                    <p>{{$question->answer}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                @if ($ratings->count() > 0)
                                    <div class="box_content " id="course_rating">
                                        <div class="head_rate">
                                            <div class="flex-center-h text">
                                                <h6>@lang('lang.general_rating')</h6>
                                                <div class="more">
                                                    <span>{{$course->averageRate()}}</span>
                                                    <div class="stars">
                                                        @for ($i = 0; $i < floor($course->averageRate()); $i++)
                                                            <i class="las la-star"></i>
                                                        @endfor
                                                        @for ($i = 0; $i < (5 - floor($course->averageRate())); $i++)
                                                            <i class="lar la-star"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            @foreach ($ratings as $rating)
                                                <div class="box_rate">
                                                    <span class="icon"><i class="fal fa-user-circle"></i></span>
                                                    <div class="box">
                                                        <h6 class="name">{{$rating->user->name}}</h6>
                                                        <div class="stars">
                                                            @for ($i = 0; $i < floor($rating->rating); $i++)
                                                                <i class="las la-star"></i>
                                                            @endfor
                                                            @for ($i = 0; $i < (5 - floor($rating->rating)); $i++)
                                                                <i class="lar la-star"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="comment">{{$rating->comment}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                {{--                            <div class="box_content" id="students_result">--}}
                                {{--                                <div class="content_tab">--}}
                                {{--                                    @if ($results->count() > 0)--}}
                                {{--                                        <div class="students_result owl-carousel owl-theme">--}}
                                {{--                                            @foreach ($results as $result)--}}
                                {{--                                                <div class="item_carousel">--}}
                                {{--                                                    <a href="{{asset($result->image)}}" class="box venobox">--}}
                                {{--                                                        <div class="image"><img src="{{asset($result->image)}}" alt=""></div>--}}
                                {{--                                                        <h6 class="name">{{$result->student_name}}</h6>--}}
                                {{--                                                    </a>--}}
                                {{--                                                </div>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        </div>--}}
                                {{--                                    @else--}}
                                {{--                                         <div class="alert alert-danger text-center">--}}
                                {{--                                             <b><strong>@lang('lang.course_results_empty')</strong></b>--}}
                                {{--                                         </div>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}
                                <div class="box_content" id="course_bag">
                                    <div class="table_content book_pdf h-100 flex-center">
                                        {!! $course->course_bag !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 wow animate__animated animate__fadeInUp">
                    <div class="course_side_list">
                        <ul class="list">
                            <li>
                                <img src="images/icons/student.png" alt="">
                                <span
                                    class="text">@lang('lang.subscribers'): {{$course->subscribers > 0 ? $course->subscribers : $course->subscribers()}} @lang('lang.student')</span>
                            </li>
                            <li>
                                <img src="images/icons/clock.png" alt="">
                                <span
                                    class="text">@lang('lang.peroid') : {{$course->peroid}} (@lang('lang.day')) </span>
                            </li>

                        </ul>
                        <ul class="users_list">
                            @if ($course->teachers->count() > 0)
                                @foreach ($course->teachers as $teacher)
                                    <li class="user">
                                        <img src="{{asset($teacher->image ?? 'user.jpg' )}}" alt="">
                                        <span class="text">{{$teacher->name}}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="add-cart-h">
                            @if(auth()->check())
                                @if ($course->subscribed())
                                    <a href="{{route('site.course-units',$course->id)}}" class="btn-cart">
                                        <span>@lang('lang.enter_course')</span>
                                    </a>
                                @else
                                    @if ($course->open == 1)
                                        @if($course->type == 'free')
                                            <a href="{{ route('subscribe_free_course', $course->id) }}" class="btn-cart" data-id="{{$course->id}}">
                                            <i class="la la-shopping-bag"></i>
                                            <span class="">@lang('lang.subscribe free course')</span>
                                        </a>
                                        @else
                                            <a href="#" class="btn-cart add_to_cart" data-id="{{$course->id}}">
                                            <i class="la la-shopping-bag"></i>
                                            <span class="">@lang('lang.add_to_cart')</span>
                                        </a>
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if($course->type == 'free')
                                    <a href="{{route('login')}}" class="btn-cart">
                                    <i class="la la-shopping-bag"></i>
                                    <span class="">@lang('lang.subscribe free course')</span>
                                </a>
                                @else
                                    <a href="{{route('login')}}" class="btn-cart">
                                    <i class="la la-shopping-bag"></i>
                                    <span class="">@lang('lang.add_to_cart')</span>
                                </a>
                                @endif
                            @endif
                            <br>
                            <h4 class="price-h">
                            <span class="new-price">
                                <span
                                    class="num">{{$course->price_after ? $course->price_after : $course->price}}</span> @lang('lang.rs')
                            </span>
                            @if($course->price_after !== null)
                                <span class="old-price">
                                    {{$course->price_after ? $course->price : ''}} @lang('lang.rs')
                                </span>
                            @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            @if($related_courses->count() > 0)
                <div class="similar_courses mt-60">
                    <div class="row heading_line">
                        <div class="col-md-auto wow animate__animated animate__fadeInUp">
                            <h4>@lang('lang.related_courses')</h4>
                        </div>
                        <div class="col">
                            <hr class="hr-width">
                        </div>
                    </div>
                    <div class="courses-slider owl-carousel owl-theme wow animate__animated animate__fadeInUp">
                        @foreach ($related_courses as $item)
                            <div class="item">
                                <div class="cour-block">
                                    <div class="img-block">
                                        <a href="{{route('course.show',$item->id)}}" class="img">
                                            <img src="{{asset($item->image)}}" alt="#"/>
                                        </a>
                                        <div class="overlay">
                                            <div>
                                                <div class="price">
                                                    <span class="num">{{$item->price_after ? : $item->price}}</span>
                                                    <span>@lang('lang.rs')</span>
                                                </div>
                                                <div class="rate">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                </div>
                                            </div>


                                            @if($item->preview_video_platform == 'youtube')

                                                {{--                                                <div class="video_container" data-plyr-poster="{{asset($course->image)}}">--}}
                                                {{--                                                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $item->preview_video_id }}"></div>--}}
                                                {{--                                                </div>--}}

                                                <a class="venobox play-btn vbox-item play_icon" data-autoplay="true"
                                                   data-vbtype="video"
                                                   href="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720">
                                                    <button data-id="video1"><i class="las la-play"></i></button>
                                                </a>
                                            @elseif($item->preview_video_platform == 'vimeo')

                                                {{--                                                <div class="video_container" data-plyr-poster="{{asset($course->image)}}">--}}
                                                {{--                                                    <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $item->preview_video_id }}"></div>--}}
                                                {{--                                                </div>--}}
                                                <a class="venobox play-btn vbox-item play_icon" data-autoplay="true"
                                                   data-vbtype="video"
                                                   href="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p"
                                                    <button data-id="video1"><i class="las la-play"></i></button
                                                </a>
                                            @endif
                                            <div class="video_box text-center mt-30">
                                                {{--                                            <iframe class="vimeo"--}}
                                                {{--                                                src="https://player.vimeo.com/video/{{ $item->preview_video }}?autoplay=1&loop=1"--}}
                                                {{--                                                width="640" height="480" frameborder="0"--}}
                                                {{--                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>--}}
                                            </div>
                                            <button data-id="video1" class="close_video"><i class="far fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <a href="{{route('course.show',$item->id)}}" class="name">{{$item->title}}</a>
                                        <div class="sec-h">
                                            <p class="desc text-ellipsis">{!!$item->desc, 130!!}</p>
                                        </div>
                                        <ul>
                                            <li>
                                                @php
                                                    $teachers = $item->teachers;
                                                @endphp
                                                @if ($item->teachers->count() > 0)
                                                    @foreach ($item->teachers as $key => $teacher)
                                                        <span>{{$teacher->name}} @if (count($teachers) != $key+1 )
                                                                -
                                                            @endif</span>
                                                    @endforeach
                                                @endif
                                            </li>
                                            <li>
                                                <i class="la la-clock"></i>
                                                <span>{{$item->peroid}} (@lang('lang.day'))</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="add-cart-h">
                                        @if(auth()->check())
                                            @if ($item->subscribed())
                                                <a href="{{route('site.course-units',$item->id)}}" class="btn-cart">
                                                    <span>@lang('lang.enter_course')</span>
                                                </a>
                                            @else
                                                @if ($item->open == 1)
                                                    <a href="#" class="btn-cart add_to_cart" data-id="{{$item->id}}">
                                                        <i class="la la-shopping-bag"></i>
                                                        <span class="">@lang('lang.add_to_cart')</span>
                                                    </a>
                                                @endif
                                            @endif

                                        @else
                                            <a href="{{route('course.show',$item->id)}}" class="btn-cart">
                                                <i class="la la-book"></i>
                                                <span class="">@lang('lang.show')</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--========================== End single_course page =============================-->


    <div class="modal fade text-center" id="desc_modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-head p-3 border-bottom">
                    <h5 class="m-0">{{$course->title}}</h5>
                </div>
                <div class="modal-body">
                    <p class="desc">
                        @if(auth()->check())
                            @if ($course->subscribed())
                                <a href="{{route('site.course-units',$course->id)}}" class="btn-cart">
                                    <span>@lang('lang.enter_course')</span>
                                </a>
                            @else
                                @if ($course->open == 1)
                                    @if($course->type == 'free')
                                        <a href="{{ route('subscribe_free_course', $course->id) }}" class="btn-cart" data-id="{{$course->id}}">
                                        <i class="la la-shopping-bag"></i>
                                        <span class="">@lang('lang.subscribe free course')</span>
                                    </a>
                                    @else
                                        <a href="#" class="btn-cart add_to_cart" data-id="{{$course->id}}">
                                        <i class="la la-shopping-bag"></i>
                                        <span class="">@lang('lang.add_to_cart')</span>
                                    </a>
                                    @endif
                                @endif
                            @endif

                        @else
                            @if($course->type == 'free')
                                <a href="{{route('login')}}" class="btn-cart">
                                <i class="la la-book"></i>
                                <span class="">@lang('lang.subscribe free course')</span>
                            </a>
                            @else
                                <a href="{{route('login')}}" class="btn-cart">
                                <i class="la la-book"></i>
                                <span class="">@lang('lang.login')</span>
                            </a>
                            @endif
                        @endif
                    </p>
                </div>
                {{--  <div class="btns text-center p-3 pb-4">
                    <button type="button" class="main-btn sec border-0" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="main-btn main border-0">إرسال</button>
                </div>  --}}
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{asset('site/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('site/js/countDown.js')}}"></script>

@endsection

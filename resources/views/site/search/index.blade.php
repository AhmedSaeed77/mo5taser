@extends('site.includes.master')
@section('content')
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <a href="{{route('courses')}}" class="home">@lang('lang.courses')</a>
        <span class="break">/</span>
        <span class="current">@lang('lang.search_results')</span>
    </div>
</div>

<!--========================== Start single_course page =============================-->
<section class="single_course_page">
    <div class="container">
        @if($courses->count() > 0)
            <div class="similar_courses mt-60">
                <div class="row heading_line">
                    <div class="col-md-auto wow animate__animated animate__fadeInUp">
                        <h4>@lang('lang.courses')</h4>
                    </div>
                    <div class="col">
                        <hr class="hr-width">
                    </div>
                </div>
                <div class="courses-slider owl-carousel owl-theme wow animate__animated animate__fadeInUp">
                    @foreach ($courses as $item)
                        <div class="item">
                            <div class="cour-block">
                                <div class="img-block">
                                    <a href="{{route('course.show',$item->id)}}" class="img">
                                        <img src="{{asset($item->image)}}" alt="#" />
                                    </a>
                                    <div class="overlay">
                                        <div>
                                            <div class="price">
                                                <span class="num">{{$item->price_after ? $item->price_after : $item->price}}</span>
                                                <span>@lang('lang.rs')</span>
                                            </div>
                                            <div class="rate">
                                                @if ($item->averageRate() > 0)
                                                    @for ($i = 0 ; $i < $item->averageRate() ; $i++)
                                                        <i class="la la-star"></i>
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                        <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>
                                        <div class="video_box text-center mt-30">
                                            @if($item->preview_video_platform == 'vimeo')
                                                <div class="video_container">
                                                    <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $item->preview_video_id }}"></div>
                                                </div>
                                            @elseif($item->preview_video_platform == 'youtube')
                                                <div class="video_container">
                                                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $item->preview_video_id }}"></div>
                                                </div>
                                            @endif
{{--                                            <iframe class="vimeo"--}}
{{--                                                src="https://player.vimeo.com/video/{{ $item->preview_video }}?autoplay=1&loop=1"--}}
{{--                                                width="640" height="480" frameborder="0"--}}
{{--                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>--}}
                                        </div>
                                        <button  data-id="video1" class="close_video"><i class="far fa-times"></i></button>
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
                                                 <span>{{$teacher->name}} @if (count($teachers) != $key+1 ) -  @endif</span>
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
                                                    <span class="" >@lang('lang.add_to_cart')</span>
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{route('login')}}" class="btn-cart">
                                            <i class="la la-shopping-bag"></i>
                                            <span class="" >@lang('lang.add_to_cart')</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center">
                <b>@lang('lang.no_search_results')</b>
            </div>
        @endif
    </div>
</section>
<!--========================== End single_course page =============================-->

@endsection

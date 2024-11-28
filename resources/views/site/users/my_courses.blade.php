@php use Carbon\Carbon; @endphp
@extends('site.includes.master')
@section('content')

<!--========================== Start myCourses page =============================-->
    <section class="myCourses_page paddingPage">
        <div class="container">
            <h4 class="heading_2 mb-50 text-center">@lang('lang.courses')</h4>
            <div class="row">
                @if ($courses->count() > 0)
                    @foreach ($courses as $key => $course)
                        <div class="col-lg-4 col-md-6">
                            <div class="cour-block">
                                <div class="img-block">
                                    <a href="{{route('course.show',$course->id)}}" class="img">
                                        <img src="{{asset($course->image)}}" alt="#" />
                                    </a>
                                    <div class="overlay">
                                        <div>
                                            <div class="progression_level">
                                                <span class="text">@lang('lang.progress')</span>
                                                <span class="num">{{$course->progress(auth()->id())}} %</span>
                                            </div>
                                            @php
                                                $rate_user = \App\Models\Rating::where(['course_id'=>$course->id,'user_id' =>auth()->id()])->first();
                                            @endphp
                                            @if (!$rate_user)
                                                <div class="progression_level cursor-pointer" data-bs-toggle="modal" data-bs-target="#review_modal{{$key}}">
                                                    <span class="text">@lang('lang.add_rating')</span>
                                                </div>
                                                    {{--  start modal  --}}
                                                    <!--==================== Start review modal ========================-->
                                                    <div class="modal fade review_modal" id="review_modal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                    <!--==================== End review modal ========================-->
                                                    {{--  end modal  --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="details">
                                    <a href="{{route('course.show',$course->id)}}" class="name">{{$course->title}}</a>
                                    <div class="rate">
                                        @if ($course->averageRate() > 0)
                                            @for ($i = 0 ; $i < $course->averageRate() ; $i++)
                                                <i class="fas la-star"></i>
                                            @endfor
                                        @endif
                                        @if ($course->averageRate() < 5)
                                            @for ($i = 0 ; $i < 5- $course->averageRate() ; $i++)
                                                <i class="far la-star"></i>
                                            @endfor
                                        @endif
                                    </div>
                                    {{--  <div class="sec-h">
                                        <p class="desc text-ellipsis">{!! $course->desc !!}</p>
                                    </div>  --}}
                                    <ul>
                                        @php
                                            $teachers = $course->teachers()->distinct()->get();
                                        @endphp
                                        <li>
                                            <i class="la la-user"></i>
                                            @if ($teachers->count() > 0)
                                                @foreach ($teachers as $key => $teacher)
                                                <span>{{$teacher->name}} @if (count($teachers) != $key+1 ) -  @endif</span>
                                                @endforeach
                                            @endif
                                        </li>
                                        <li style="-webkit-line-clamp: unset;">
                                            @php
                                                $subscibe = \App\Models\Subscribe::where(['course_id' => $course->id , 'active' => 1,'user_id' => auth()->id()])->first();
                                                $days = Carbon::parse($subscibe->end_subscribe)->addDay()->diffInDays() . ' ' . __('lang.days');
                                            @endphp
                                            <i class="la la-clock"></i>
                                            @if(Carbon::parse($subscibe->end_subscribe)->isPast() || Carbon::parse($subscibe->end_subscribe)->isToday())
                                                <span>@lang('lang.subscribe ended')</span>
                                            @else
                                                <span>{{$course->peroid}} (@lang('lang.day'))</span>

                                                <br>
                                                <span>@lang('lang.left_days') {{$days}} </span>
                                            @endif

                                        </li>
                                        <li>
                                            <i class="las la-users"></i>
                                            <span>@lang('lang.number of subscribers') : {{$course->subscribers > 0 ? $course->subscribers : $course->subscribers()}}</span>
                                       </li>
                                    </ul>
                                </div>
                                <div class="add-cart-h">
                                    <a href="{{route('site.course-units',$course->id)}}" class="btn-cart">
                                        <span>@lang('lang.enter_course')</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
    </section>
<!--========================== End myCourses page =============================-->


@endsection

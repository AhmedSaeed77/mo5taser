@extends('site.includes.master')
@section('content')


<!--========================== Start profile page =============================-->
<section class="profile_page mt-60 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 text-center">@lang('lang.course_units') -- ({{$course->title}})</h4>
        @if ($units->count() > 0)
        <div class="content_section">
                @foreach ($units as $unit)
                    <a href="{{route('single-course',$unit->id)}}" class="box">
                        <div class="image">
                            <img src="{{asset($unit->image)}}" alt="">
                        </div>
                        <span class="text">{{$unit->title}}</span>
                    </a>
                @endforeach
            </div>
        @else
        <div class="row">
            <div class="alert alert-danger text-center">
            <b>@lang('lang.no_units')</b>
            </div>
        </div>
        @endif
    </div>
</section>
<!--========================== End profile page =============================-->

<style>
    .profile_page .content_section .box .image {
        height: 124px;
        width: 124px;
        overflow: hidden;
        border-radius: 50%;
        margin: 0 0 15px;
    }

    .profile_page .content_section .box .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>

@endsection

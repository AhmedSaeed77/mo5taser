@extends('site.includes.master')
@section('content')

<!--========================== Start profile page =============================-->
<section class="profile_page mt-60 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 text-center">@lang('lang.personal_account')</h4>
        <div class="content_section">
            <a href="{{route('attempts','contests')}}" class="box">
                <div class="image">
                    <img src="{{asset('site/images/profile/account.png')}}" alt="">
                </div>
                <span class="text">@lang('lang.contests')</span>
            </a>
            <a href="{{route('attempts','exams')}}" class="box">
                <div class="image">
                    <img src="{{asset('site/images/profile/account.png')}}" alt="">
                </div>
                <span class="text">@lang('lang.my_exams')</span>
            </a>
            <a href="{{route('my-courses')}}" class="box">
                <div class="image">
                    <img src="{{asset('site/images/profile/exam.png')}}" alt="">
                </div>
                <span class="text">@lang('lang.my_courses')</span>
            </a>
            <a href="{{route('profile')}}" class="box">
                <div class="image">
                    <img src="{{asset('site/images/profile/online-education.png')}}" alt="">
                </div>
                <span class="text">@lang('lang.my_profile')</span>
            </a>
        </div>
    </div>
</section>
<!--========================== End profile page =============================-->

@endsection

@extends('site.includes.master')
@section('content')
<!--========================== Start contest page =============================-->
<section class="contest_page">
    <div class="container">
        <div class="contest_box wow animate__animated animate__fadeInUp">
            <div class="text-center">
                <div class="headPage text-center">
                    <span>@lang('lang.contest_in')</span>
                    <p class="main-color">( {{$pass->childLevel->title}} )</p>
                </div>
            </div>
            <div class="desc mt-30 mb-60 text-center">
                <p>@lang('lang.contest_desc')</p>
            </div>
            <div class="rules">
                <h6 class="head main-color mb-20">@lang('lang.contest_conditions')</h6>
                <ul>
                    <li>@lang('lang.contest_attempt')</li>
                    <li>@lang('lang.contest_time') ({{$pass->questions_number}} @lang('lang.questions') - {{$pass->exam_time}} @lang('lang.mins')) </li>
                    <li>@lang('lang.contest_gift')</li>
                </ul>
            </div>
            <div class="text-center">
                <a href="{{route('enter_exam',$pass->id)}}" class="main-btn main">@lang('lang.enter_contest')</a>
            </div>
        </div>
    </div>
</section>
<!--========================== End contest page =============================-->
@endsection

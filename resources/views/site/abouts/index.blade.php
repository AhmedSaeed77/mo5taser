@extends('site.includes.master')
@section('content')
<!--========================== Start page header =============================-->
    <section class="page_header" style="background-image: url({{asset($about->cover ?? '')}});">
        <div class="container content h-100">
            <div class="breadcrumbs">
                <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
                <span class="break">/</span>
                <span class="current">@lang('lang.about_us')</span>
            </div>
            <h4 class="page_name m-0">@lang('lang.about_us')</h4>
        </div>
    </section>
<!--========================== Start about page =============================-->
<section class="about_page wow animate__animated animate__fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="info">
                    <h6 class="main-color">@lang('lang.about_us')</h6>
                    <p>{{$about->about ?? ''}}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="image">
                    <img src="{{asset($about->image ?? '')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== End about page =============================-->


<!--========================== Start team section =============================-->
@if($teams->count() > 0)
<section class="team_section">
    <div class="container">
        <div class="heading text-center wow animate__animated animate__fadeInUp">
            <h4>@lang('lang.team')</h4>
        </div>
            <div class="row wow animate__animated animate__fadeInUp">
        @foreach ($teams as $team)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="team_box">
                        <div class="image"><img src="{{asset($team->image)}}" alt=""></div>
                        <div class="info text-center">
                            <h6 class="name">{{$team->name}}</h6>
                            <span class="job_title">{{$team->job}}</span>
                        </div>
                    </div>
                </div>
        @endforeach
            </div>
    </div>
</section>
@endif
<!--========================== End team section =============================-->
@endsection

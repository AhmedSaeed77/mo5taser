@extends('site.includes.master')
@section('content')
<main class="main-content">
    <!-- Start slider-home -->
    <section class="banner-home">

        <x-slider></x-slider>

        <x-search></x-search>
    </section>
    <!-- End Slider-home -->

    <!-- Start Why-h -->
    <x-why-us></x-why-us>
    <!-- End Why-h -->

    <!-- Start Courses-h -->
    <x-course></x-course>
    <!-- End Courses-h -->

    <!-- Start Teacher-h -->
    <x-teacher></x-teacher>
    <!-- End Teacher-h -->

    <!-- Start News-h -->
    <x-news></x-news>
    <!-- End News-h -->

    <!-- Start Say-h -->
    <x-testimonail></x-testimonail>
    <!-- End Say-h -->

    <!-- Start Apps-h -->
    <section class="apps-h">
        <div class="animations">
            <div class="right">
                <span class="shape shape1"></span>
                <span class="shape shape2"></span>
                <span class="shape shape3"></span>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Col -->
                <div class="col-md-6 col-sm-12">
                    <div class="text-apps">
                        <p class="wow animate__animated animate__fadeInUp">
                            @lang('lang.download_apps')
                            <br /> @lang('lang.great_experience')
                        </p>
                        <div class="down-apps">
                            <a href="#" target="_blank" class="wow animate__animated animate__fadeInUp">
                                <img data-original="{{asset('site/images/app.png')}}" alt="#" class="lazyload"/>
                            </a>
                            <a href="#" target="_blank" class="wow animate__animated animate__fadeInUp">
                                <img data-original="{{asset('site/images/google.png')}}" alt="#" class="lazyload"/>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Col -->

                <!-- Col -->
                <div class="col-md-6 col-sm-12">
                    <div class="img-app wow animate__animated animate__fadeInUp">
                        <div class="img img1">
                            <img data-original="{{asset('site/images/app_2.png')}}" alt="#" class="lazyload"/>
                        </div>
                        <div class="img img2">
                            <img data-original="{{asset('site/images/app_3.png')}}" alt="#" class="lazyload"/>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
            </div>
        </div>
    </section>
    <!-- End Apps-h -->
</main>
@endsection

@section('js')

@endsection

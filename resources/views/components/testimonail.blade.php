@if ($testimonails->count() > 0)
    <section class="say-h">
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
                    <div class="title">
                        <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.testimonail')</h3>
                    </div>
                    <div class="say-inner">
                        <div class="say-slider owl-carousel owl-theme wow animate__animated animate__fadeInUp">
                            <!-- Itme -->
                            @foreach ($testimonails as $key => $testimonail)
                                <div class="item" data-dot="<button class='nub-dot'><div class='img'><img data-original='{{asset($testimonail->image)}}' class='lazyload' /></div></button>">
                                    <div class="say-block">
                                        <div class="say-block-in">
                                            <p>{{$testimonail->comment}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- /Itme -->
                        </div>
                    </div>
                </div>
                <!-- /Col -->

                <!-- Col -->
                <div class="col-lg-6 contest_main">
                    <div class="title">
                        <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.contests')</h3>
                    </div>
                    <div class="contest_div owl-carousel owl-theme wow animate__animated animate__fadeInUp">
                        @if ($pass_contests->count() > 0)
                            @foreach ($pass_contests as $pass_contest)
                                <div class="contest_box">
                                    <div class="image">
                                        @if ($pass_contest->childLevel->image)
                                        <img data-original="{{asset($pass_contest->childLevel->image)}}" alt="" class="lazyload">
                                        @else
                                        <img data-original="{{asset('site/images/contest.jpg')}}" alt="" class="lazyload">
                                        @endif
                                    </div>
                                    <div class="info">
                                        <h5 class="main-color mb-20">( {{$pass_contest->childLevel->title}} )</h5>
                                        <p class="mb-20">@lang('lang.subscribe_contest')</p>
                                        <a href="{{route('contest',$pass_contest->id)}}" class="main-btn trans">@lang('lang.show')</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="alert alert-danger text-center">
                            <strong>@lang('lang.no_contest')</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- /Col -->
            </div>
        </div>
    </section>
@endif

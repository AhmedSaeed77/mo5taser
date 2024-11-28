@if ($whys->count() > 0)
    <section class="why-h">
        <div class="container">
            <div class="row">
                <!-- Col -->
                <div class="col-md-12">
                    <div class="title">
                        <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.why_choose')</h3>
                        <p class="wow animate__animated animate__fadeInUp">@lang('lang.advantages')</p>
                    </div>
                </div>
                <!-- /Col -->

                <!-- Col -->
                @if($whys->count() >= 1)
                <div class="col-lg-3 col-md-6 wow animate__ animate__fadeInUp  animated">
                    <div class="why-block">
                        <div class="icon">
                            <img src="{{asset('site/images/icon1.png')}}" alt="#" loading="lazy"/>
                        </div>
                        <div class="details">
                            <h3>{{$whys[0]->title}}</h3>
                            <p>{{$whys[0]->content}}</p>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
                @endif
                @if($whys->count() >= 2)
                <!-- Col -->
                <div class="col-lg-3 col-md-6 wow animate__ animate__fadeInUp  animated">
                    <div class="why-block">
                        <div class="icon">
                            <img src="{{asset('site/images/icon2.png')}}" alt="#" loading="lazy"/>
                        </div>
                        <div class="details">
                            <h3>{{$whys[1]->title}}</h3>
                            <p>{{$whys[1]->content}}</p>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
                @endif
                @if($whys->count() >= 3)
                <!-- Col -->
                <div class="col-lg-3 col-md-6 wow animate__ animate__fadeInUp  animated">
                    <div class="why-block">
                        <div class="icon">
                            <img src="{{asset('site/images/icon3.png')}}" alt="#"loading="lazy" />
                        </div>
                        <div class="details">
                            <h3>{{$whys[2]->title}}</h3>
                            <p>{{$whys[2]->content}}</p>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
                @endif
                @if($whys->count() >= 4)
                <!-- Col -->
                <div class="col-lg-3 col-md-6 wow animate__ animate__fadeInUp  animated">
                    <div class="why-block">
                        <div class="icon">
                            <img src="{{asset('site/images/icon4.png')}}" alt="#" loading="lazy"/>
                        </div>
                        <div class="details">
                            <h3>{{$whys[3]->title}}</h3>
                            <p>{{$whys[3]->content}}</p>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
                @endif
            </div>
        </div>
    </section>
@endif

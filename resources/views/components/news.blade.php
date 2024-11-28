@if($news->count() > 0)
<section class="news-h">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-md-12">
                <div class="title">
                    <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.news')</h3>
                </div>

                <div class="news-slider owl-carousel owl-theme wow animate__animated animate__fadeInUp">
                    <!-- Item -->
                    @foreach ($news as $new)
                        <div class="item">
                            <div class="news-block">
                                <div class="img-block">
                                    <a href="{{route('show.news',$new->id)}}" class="img">
                                        <img data-original="{{asset($new->image)}}" alt="#" class="lazyload"/>
                                    </a>
                                </div>
                                <div class="details">
                                    <span class="date">
                                        <i class="la la-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse( $new->created_at )->format('Y-m-d')}}
                                    </span>
                                    <h3 class="name">{{$new->title}}</h3>
                                    <a href="{{route('show.news',$new->id)}}" class="more">
                                        <span>@lang('lang.show_news')</span>
                                        <i class="la la-angle-left"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- /Item -->
                </div>
            </div>
            <!-- /Col -->

            <!-- Col -->
            <div class="col-md-12">
                <a href="{{route('news')}}" class="btn btn-border wow animate__animated animate__fadeInUp">
                <span>@lang('lang.all_news')</span>
                </a>
            </div>
            <!-- /Col -->
        </div>
    </div>
</section>
@endif

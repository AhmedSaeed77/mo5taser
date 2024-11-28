@extends('site.includes.master')
@section('content')
<!--========================== Start news page =============================-->
    <section class="news_page">
        <div class="container">
            <h4 class="headPage mb-50 text-center wow animate__animated animate__fadeInUp">@lang('lang.news')</h4>
            @if($news->count() > 0)
                <div class="row wow animate__animated animate__fadeInUp">
                    @foreach ($news as $new)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="news-block">
                                <div class="img-block">
                                    <a href="{{route('show.news',$new->id)}}" class="img">
                                        <img src="{{asset($new->image)}}" alt="#" />
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
                </div>
                <div class="custom_pagination mt-40 wow animate__animated animate__fadeInUp">
                    {{$news->links()}}
                </div>
            @endif
        </div>
    </section>
    <!--========================== End news page =============================-->

@endsection

@extends('site.includes.master')
@section('content')
<!--========================== Start single news page =============================-->
    <section class="single_news_page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="new_content">
                        <a href="{{asset($new->image)}}" class="image venobox"><img src="{{asset($new->image)}}" alt=""></a>
                        <div class="info">
                            <div class="date flex_center_h">
                                <i class="las la-calendar"></i>
                                <span class="text">{{ \Carbon\Carbon::parse( $new->created_at )->format('Y-m-d')}}</span>
                            </div>
                            <h6 class="name">{{$new->title}}</h6>
                            <div class="desc">
                                <p>{{$new->content}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                @if($latest_news->count() > 0)
                <div class="col-lg-4">
                    <div class="other_news">
                        <h6 class="head">@lang('lang.another_news')</h6>
                        <div class="content">
                            @foreach ($latest_news as $item)
                                <a href="{{route('show.news',$item->id)}}" class="item">
                                    <div class="image"><img src="{{asset($item->image)}}" alt=""></div>
                                    <div class="info">
                                        <p class="name">{{$item->title}}</p>
                                        <div class="date flex_center_h">
                                            <i class="main-color las la-calendar"></i>
                                            <span class="text">{{ \Carbon\Carbon::parse( $item->created_at )->format('Y-m-d')}}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!--========================== End single news page =============================-->

@endsection

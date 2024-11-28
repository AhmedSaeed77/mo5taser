@extends('site.includes.master')
@section('content')

<!--========================== Start page header =============================-->
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <span class="current">@lang('lang.assemblies')</span>
    </div>
</div>
<!--========================== End page header =============================-->

<!--========================== Start general exams page =============================-->
<section class="general_exams_page mt-40 mb-40 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 mb-30">@lang('lang.assemblies')</h4>
        <div class="row">
            <div class="col-lg-3">
                <div class="exams_card sticky">
                    <h5 class="head">@lang('lang.assemblies')</h5>
                    <ul>
                        @if ($categories->count() > 0)
                            @foreach ($categories as $key => $category)
                                <li class="mou_tab {{$key == 0 ? 'active' : ''}}" data-content="section_{{$key}}">{{$category->title}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 mt-md-30">
                <div class="main_content">
                    @if ($categories->count() > 0)
                        <div class="row">

                        @foreach ($categories as $key => $category)
                            @foreach ($category->assemblies as $item)
                            <div class="box_content {{$key == 0 ? 'active' : ''}} col-md-4 col-sm-6 main_box section_{{$key}}" >
                                    @if($item->type == 'book')
                                        <div class="box_Gexam">
                                            <div class="image">
                                                <img src="{{asset($item->image)}}" alt="#" />
                                            </div>
                                            <div class="info">
                                                <h6 class="name text-ellipsis">{{$item->title}}</h6>
                                                <div class="details">
                                                    <p>{{ \Illuminate\Support\Str::limit($item->content, 100, '') }}</p>
                                                </div>
                                                <a href="{{route('assemblies_show',$item->id)}}" class="main-btn trans w-100">
{{--                                                    @lang('lang.show')--}}
                                                    @lang('lang.show')
                                                </a>
                                            </div>
                                        </div>
                                    @else

                                        <div class="box_Gexam box_video">
                                            <div class="image">
                                                @if($item->video_platform == 'youtube')
                                                    <a class="venobox" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/embed/{{ $item->video_id }}?vq=hd720&rel=0">
                                                        <img src="{{asset($item->image)}}" alt="#" />
                                                    </a>
                                                @elseif($item->video_platform == 'vimeo')
                                                    <a class="venobox" data-autoplay="true" data-vbtype="video" href="https://player.vimeo.com/video/{{ $item->video_id }}?quality=720p">
                                                        <img src="{{asset($item->image)}}" alt="#" />
                                                    </a>
                                                @endif

                                            </div>
                                            <div class="info">
                                                <h6 class="name text-ellipsis">{{$item->title}}</h6>
                                                <div class="details">
                                                    <p>{{ \Illuminate\Support\Str::limit($item->content, 120, '') }}</p>
                                                </div>
                                                @if($item->video_platform == 'youtube')
                                                    <a class="main-btn trans w-100 venobox" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/embed/{{ $item->video_id }}?vq=hd720&rel=0">
                                                        @lang('lang.watch_video')
                                                    </a>
                                                @elseif($item->video_platform == 'vimeo')
                                                    <a class="main-btn trans w-100 venobox" data-autoplay="true" data-vbtype="video" href="https://player.vimeo.com/video/{{ $item->video_id }}?quality=720p">
                                                        @lang('lang.watch_video')
                                                    </a>
                                                @endif


                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                        </div>

                    @else
                        <div class="alert alert-danger text-center">
                            <b>@lang('lang.no_cats')</b>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
<!--========================== End general exams page =============================-->

@endsection

@section('js')
    <script>
        $(function () {
            $(document).on('click', '.mou_tab', function () {
                $('.mou_tab').removeClass('active');
                $('.main_box').removeClass('active');
                $(this).addClass('active');
                $('.' + $(this).attr('data-content')).addClass('active');
            });
        });
    </script>
@endsection

<section class="courses-h" id="courses">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-sm-12">
                <div class="title title-sec">
                    <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.courses')</h3>
                </div>
            </div>
            <!-- /Col -->

            <!-- Col -->
            <div class="col-sm-12">
                <div class="nav nav-pills wow animate__animated animate__fadeInUp">
                    @if ($categories->count() > 0)
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#cor0" type="button">
                            @lang('lang.all')
                        </button>
                        @foreach ($categories as $key => $category)
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cor{{$loop->iteration}}" type="button">
                                {{$category->title}}
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- /Col -->

            <!-- Col -->
            <div class="col-md-12 p-0">
                <div class="tab-content wow animate__animated animate__fadeInUp">
                    @if ($categories->count() > 0)
                        <div class="tab-pane fade show active" id="cor0">
                            <div class="courses-slider owl-carousel owl-theme">
                                @foreach ($courses as $item)
                                    <div class="item">
                                        <div class="cour-block">
                                            <div class="img-block">
                                                <a href="{{route('course.show',$item->id)}}" class="img">
                                                    <img data-original="{{asset($item->image)}}" alt="#" class="lazyload"/>
                                                </a>
                                                <div class="overlay">
                                                    <div>
                                                        <div class="price">
                                                            <span class="num">{{$item->price_after ? $item->price_after : $item->price}}</span>
                                                            <span>@lang('lang.rs')</span>
                                                        </div>
                                                        <div class="rate">
                                                            @if ($item->averageRate() > 0)
                                                                @for ($i = 0 ; $i < $item->averageRate() ; $i++)
                                                                    <i class="fas la-star"></i>
                                                                @endfor
                                                            @endif
                                                            @if ($item->averageRate() < 5)
                                                                @for ($i = 0 ; $i < 5- $item->averageRate() ; $i++)
                                                                    <i class="far la-star"></i>
                                                                @endfor
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($item->preview_video_platform == 'youtube')
                                                        <a href="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720" data-autoplay="true" data-vbtype="video" class="venobox vbox-item">
{{--                                                            <i class="fa fa-play"></i>--}}
                                                            <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>

                                                        </a>
                                                        {{--                                                                <iframe id="vimeo" width="640" height="480"--}}
                                                        {{--                                                                        src="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720" frameborder="0"--}}
                                                        {{--                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"--}}
                                                        {{--                                                                        allowfullscreen></iframe>--}}
                                                    @elseif($item->preview_video_platform == 'vimeo')
                                                        <a href="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p" data-autoplay="true" data-vbtype="video" class="venobox vbox-item">
{{--                                                            <i class="fa fa-play"></i>--}}
                                                            <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>

                                                        </a>
                                                        {{--                                                                <iframe id="vimeo" data-id="{{$item->id}}"--}}
                                                        {{--                                                                        src="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p"--}}
                                                        {{--                                                                        width="640" height="480" frameborder="0"--}}
                                                        {{--                                                                        allow="autoplay; fullscreen; picture-in-picture"--}}
                                                        {{--                                                                        allowfullscreen></iframe>--}}
                                                    @endif
{{--                                                    <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>--}}
{{--                                                    <div class="video_box text-center mt-30">--}}
{{--                                                        @if($item->preview_video_platform == 'youtube')--}}
{{--                                                            <iframe id="vimeo" width="640" height="480"--}}
{{--                                                                    src="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720" frameborder="0"--}}
{{--                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"--}}
{{--                                                                    allowfullscreen></iframe>--}}
{{--                                                        @elseif($item->preview_video_platform == 'vimeo')--}}
{{--                                                            <iframe id="vimeo" data-id="{{$item->id}}"--}}
{{--                                                                    src="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p"--}}
{{--                                                                    width="640" height="480" frameborder="0"--}}
{{--                                                                    allow="autoplay; fullscreen; picture-in-picture"--}}
{{--                                                                    allowfullscreen></iframe>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
                                                    <button  data-id="video1" class="close_video"><i class="far fa-times"></i></button>
                                                </div>
                                                @if ($item->open == 0)
                                                    <span class="status">@lang('lang.course_closed')</span>
                                                @endif
                                            </div>
                                            <div class="details">
                                                <a href="{{route('course.show',$item->id)}}" class="name">{{$item->title}}</a>
                                                {{--  <div class="sec-h">
                                                    <p class="desc text-ellipsis">{!!$item->desc, 130!!}</p>
                                                </div>  --}}
                                                <ul>
                                                    @php
                                                        $teachers = $item->teachers;
                                                    @endphp
                                                    <li>
                                                        <i class="la la-user"></i>
                                                        @if ($teachers->count() > 0)
                                                            @foreach ($teachers as $key => $teacher)
                                                                <span>{{$teacher->name}} @if (count($teachers) != $key+1 ) -  @endif</span>
                                                            @endforeach
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <i class="la la-clock"></i>
                                                        <span>{{$item->peroid}} (@lang('lang.day'))</span>
                                                    </li>
                                                    <li>
                                                        <i class="las la-users"></i>
                                                        <span>@lang('lang.number of subscribers') : {{$item->subscribers > 0 ? $item->subscribers : $item->subscribers()}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="add-cart-h">
                                                @if(auth()->check())
                                                    @if ($item->subscribed())
                                                        <a href="{{route('site.course-units',$item->id)}}" class="btn-cart">
                                                            <span>@lang('lang.enter_course')</span>
                                                        </a>
                                                    @else
                                                        @if ($item->open == 1)
                                                            <a href="#" class="btn-cart add_to_cart" data-id="{{$item->id}}">
                                                                <i class="la la-shopping-bag"></i>
                                                                <span class="" >@lang('lang.add_to_cart')</span>
                                                            </a>
                                                        @endif
                                                    @endif

                                                @else
                                                    <a href="{{route('course.show',$item->id)}}" class="btn-cart">
                                                        <i class="la la-book"></i>
                                                        <span class="" >@lang('lang.show')</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>







                        @foreach ($categories as $key => $category)
                            <div class="tab-pane fade show" id="cor{{$loop->iteration}}">
                                <div class="courses-slider owl-carousel owl-theme">
                                    @foreach ($category->courses as $item)
                                        <div class="item">
                                            <div class="cour-block">
                                                <div class="img-block">
                                                    <a href="{{route('course.show',$item->id)}}" class="img">
                                                        <img data-original="{{asset($item->image)}}" alt="#" class="lazyload"/>
                                                    </a>
                                                    <div class="overlay">
                                                        <div>
                                                            <div class="price">
                                                                <span class="num">{{$item->price_after ? $item->price_after : $item->price}}</span>
                                                                <span>@lang('lang.rs')</span>
                                                            </div>
                                                            <div class="rate">
                                                                @if ($item->averageRate() > 0)
                                                                    @for ($i = 0 ; $i < $item->averageRate() ; $i++)
                                                                        <i class="fas la-star"></i>
                                                                    @endfor
                                                                @endif
                                                                @if ($item->averageRate() < 5)
                                                                    @for ($i = 0 ; $i < 5- $item->averageRate() ; $i++)
                                                                        <i class="far la-star"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="video_box text-center mt-30">
                                                            @if($item->preview_video_platform == 'youtube')
                                                                <a href="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720" data-autoplay="true" data-vbtype="video" class="venobox vbox-item">
                                                                    <i class="fa fa-play"></i>
                                                                    <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>

                                                                </a>
{{--                                                                <iframe id="vimeo" width="640" height="480"--}}
{{--                                                                        src="https://www.youtube.com/embed/{{ $item->preview_video_id }}?vq=hd720" frameborder="0"--}}
{{--                                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"--}}
{{--                                                                        allowfullscreen></iframe>--}}
                                                            @elseif($item->preview_video_platform == 'vimeo')
                                                                <a href="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p" data-autoplay="true" data-vbtype="video" class="venobox vbox-item">
                                                                    <i class="fa fa-play"></i>
                                                                    <button  data-id="video1" class="play_icon"><i class="las la-play"></i></button>

                                                                </a>
{{--                                                                <iframe id="vimeo" data-id="{{$item->id}}"--}}
{{--                                                                        src="https://player.vimeo.com/video/{{ $item->preview_video_id }}?quality=720p"--}}
{{--                                                                        width="640" height="480" frameborder="0"--}}
{{--                                                                        allow="autoplay; fullscreen; picture-in-picture"--}}
{{--                                                                        allowfullscreen></iframe>--}}
                                                            @endif
                                                            {{--                                                            <iframe class="vimeo"--}}
                                                            {{--                                                                src="https://player.vimeo.com/video/{{ $item->preview_video }}?autoplay=1&loop=1"--}}
                                                            {{--                                                                width="640" height="480" frameborder="0"--}}
                                                            {{--                                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>--}}
                                                        </div>
                                                        <button  data-id="video1" class="close_video"><i class="far fa-times"></i></button>
                                                    </div>
                                                    @if ($item->open == 0)
                                                        <span class="status">@lang('lang.course_closed')</span>
                                                    @endif
                                                </div>
                                                <div class="details">
                                                    <a href="{{route('course.show',$item->id)}}" class="name">{{$item->title}}</a>
                                                    {{--  <div class="sec-h">
                                                        <p class="desc text-ellipsis">{!!$item->desc, 130!!}</p>
                                                    </div>  --}}
                                                    <ul>
                                                        @php
                                                            $teachers = $item->teachers;
                                                        @endphp
                                                        <li>
                                                            <i class="la la-user"></i>
                                                            @if ($teachers->count() > 0)
                                                                @foreach ($teachers as $key => $teacher)
                                                                    <span>{{$teacher->name}} @if (count($teachers) != $key+1 ) -  @endif</span>
                                                                @endforeach
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <i class="la la-clock"></i>
                                                            <span>{{$item->peroid}} (@lang('lang.day'))</span>
                                                        </li>
                                                        <li>
                                                            <i class="las la-users"></i>
                                                            <span>@lang('lang.number of subscribers') : {{$item->subscribers > 0 ? $item->subscribers : $item->subscribers()}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="add-cart-h">
                                                    @if(auth()->check())
                                                        @if ($item->subscribed())
                                                            <a href="{{route('site.course-units',$item->id)}}" class="btn-cart">
                                                                <span>@lang('lang.enter_course')</span>
                                                            </a>
                                                        @else
                                                            @if ($item->open == 1)
                                                                <a href="#" class="btn-cart add_to_cart" data-id="{{$item->id}}">
                                                                    <i class="la la-shopping-bag"></i>
                                                                    <span class="" >@lang('lang.add_to_cart')</span>
                                                                </a>
                                                            @endif
                                                        @endif

                                                    @else
                                                        <a href="{{route('course.show',$item->id)}}" class="btn-cart">
                                                            <i class="la la-book"></i>
                                                            <span class="" >@lang('lang.show')</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <!-- /Col -->
        </div>
    </div>
</section>

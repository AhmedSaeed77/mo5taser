@if ($content)
    @if($content->type == 'video')
        <div class="video_show">
{{--            <iframe id="course_video_url"--}}
{{--                src="https://player.vimeo.com/video/{{ $content->video_url }}"--}}
{{--                width="640" height="480" frameborder="0"--}}
{{--                allow="autoplay; fullscreen; picture-in-picture"--}}
{{--                allowfullscreen></iframe>--}}

            @if($content->video_platform == 'youtube')
                <div class="video_container">
                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $content->video_id }}"></div>
                </div>

                <!--<iframe id="course_video_url" width="640" height="480"
                        src="https://www.youtube.com/embed/{{ $content->video_id }}?vq=hd720" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                        allowfullscreen></iframe>-->
            @elseif($content->video_platform == 'vimeo')
                <div class="video_container">
                    <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $content->video_id }}"></div>
                </div>
                <!--<iframe id="course_video_url" data-id="{{$content->id}}"
                        src="https://player.vimeo.com/video/{{ $content->video_id }}?quality=720p"
                        width="640" height="480" frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen></iframe>-->
            @endif
        </div>
        <input type="hidden" id="content_id" value="{{$content->type}}">
        <input type="hidden" id="progress_id" value="{{$content->id}}">
    @endif

    @if($content->type == 'note')

        <div class="box_design homework_show">
            <h6>{{$content->title}}</h6><br>
            <div class="alert alert-success text-center">
                <p>{{$content->desc}}</p>
            </div>
        </div>
        <input type="hidden" id="content_id" value="{{$content->type}}">
        <input type="hidden" id="progress_id" value="{{$content->id}}">
    @endif


    {{--  exam content  --}}
    @if($content->type == 'exam')
        @php
            $questions_count = \App\Models\Question::where('content_id',$content->id)->get()->count();
        @endphp
        <div class="box_design homework_show">
            <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
            <h6>{{$content->title}}</h6>
            <p class="text">{!! $content->instructions !!}</p>
            <span class="time">@lang('lang.questions_number') <span> ( {{$content->questions_number}} )</span></span>
            <span class="time">@lang('lang.exam_time') <span> ( {{$content->exam_time}} )</span></span>

            <div class="row">
                @if ($content->getExamined() > 0)
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="{{route('exam-attempts-site',$content->id)}}" class="btn-form">
                                {{--  <strong>@lang('lang.finished_show_result')</strong>  --}}
                                <strong>@lang('lang.show_attempts')</strong>
                            </a>
                        </div><br>
                    </div>
                @endif
                @if ($content->getExamined() < $content->attempts_count)
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="{{route('course-exam',$content->id)}}" class="btn-form">@lang('lang.start_now')</a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <input type="hidden" id="content_id" value="{{$content->type}}">
        <input type="hidden" id="progress_id" value="{{$content->id}}">
    @endif


    {{--  split exam  --}}
    @if($content->type == 'split_test')
        @php
            $categories = \App\Models\ContentCategory::where('content_id',$content->id)->get();
            $questions_count = array_sum($categories->pluck('questions_number')->toArray());
            $questions_exist = \App\Models\Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get()->count();
        @endphp
        <div class="box_design homework_show">
            <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
            <h6>{{$content->title}}</h6>
            <p class="text">{!! $content->instructions !!}</p>
            @if($categories->count() > 0)
                <span class="time">@lang('lang.categories_count') <span> ( {{$categories->count()}} )</span></span>
                {{--  <span class="time">@lang('lang.exam_time') <span> ( {{$content->exam_time}} )</span></span>  --}}

                @if($questions_count == $questions_exist)

                    @if ($content->getExamined() > 0)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a href="{{route('exam-attempts-site',$content->id)}}" class="btn-form">
                                    <strong>@lang('lang.show_attempts')</strong>
                                </a>
                            </div><br>
                        </div>
                    @endif
                    @if ($content->getExamined() < $content->attempts_count)
                        <div class="col-md-12">
                            <div class="text-center">
                                <a href="{{route('course-exam',$content->id)}}" class="btn-form">@lang('lang.start_now')</a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-md-12">
                        <div class="text-center alert alert-danger">
                            <strong>@lang('lang.questions_not_exists')</strong>
                        </div>
                    </div>
                @endif
            @else
            <div class="col-md-12">
                <div class="text-center alert alert-danger">
                    <strong>@lang('lang.no_categories')</strong>
                </div>
            </div>

            @endif


        </div>
        <input type="hidden" id="content_id" value="{{$content->type}}">
        <input type="hidden" id="progress_id" value="{{$content->id}}">
    @endif

{{--  end split exam  --}}

    {{--  homework content  --}}
    @if($content->type == 'homework')
        @php
            $questions_count = \App\Models\Question::where('content_id',$content->id)->get()->count();
        @endphp
        <div class="box_design homework_show">
            <div class="image"><img src="{{asset('site/images/profile/exam.png')}}" alt=""></div>
            <h6>{{$content->title}}</h6>
            <p class="text">{!! $content->instructions !!}</p>
            <span class="time">@lang('lang.questions_number') <span> ( {{$content->questions_number}} )</span></span>
            @if ($content->getExamined() > 0)
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="{{route('exam-attempts-site',$content->id)}}" class="btn-form">
                                {{--  <strong>@lang('lang.finished_show_result')</strong>  --}}
                                <strong>@lang('lang.show_attempts')</strong>
                            </a>
                        </div><br>
                    </div>
                @endif
                @if ($content->getExamined() < $content->attempts_count)
                    <div class="col-md-12">
                        <div class="text-center">
                            <a href="{{route('course-exam',$content->id)}}" class="btn-form">@lang('lang.start_now')</a>
                        </div>
                    </div>
                @endif
        </div>
        <input type="hidden" id="content_id" value="{{$content->type}}">
        <input type="hidden" id="progress_id" value="{{$content->id}}">
    @endif

    {{--  zoom content  --}}
    @if($content->type == 'zoom')
        @php
            $zoom_date = Date('Y-m-d',strtotime($content->zoom_time));
            $zoom_time = Date('H:i:s',strtotime($content->zoom_time));
            $now_time = Date('H:i:s',strtotime(date("H:i:s")));

        @endphp
        @if ($content->recorded_url)
            <div class="video_show">
                @if($content->recorded_platform == 'youtube')
                <div class="video_container">
                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $content->recorded_id }}"></div>
                </div>

                    <!--<iframe width="640" height="480"
                            src="https://www.youtube.com/embed/{{ $content->recorded_id }}?vq=hd720" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                            allowfullscreen></iframe>-->
                @elseif($content->recorded_platform == 'vimeo')
                <div class="video_container">
                    <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $content->recorded_id }}"></div>
                </div>

                    <!--<iframe id="course_video_url" data-id="{{$content->id}}"
                            src="https://player.vimeo.com/video/{{ $content->recorded_id }}?quality=720p"
                            width="640" height="480" frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen></iframe>-->
                @endif
            </div>
            <input type="hidden" id="content_id" value="video">
            <input type="hidden" id="progress_id" value="{{$content->id}}">
        @else
            @if ($zoom_date >= date("Y-m-d"))
                @if ($zoom_date >= date('Y-m-d'))
                    <div class="box_design zoom_show">
                        <div class="image"><img src="{{asset('site/images/Zoom-Logo.png')}}" alt=""></div>
                            <p class="text">{{$content->title}}</p>
                            <strong id="zoom_counter"
                                data-counter="{{ $content->zoom_time }}">{{$zoom_date}}
                            </strong>
                        <div class="text-center">
                            <a href="{{$content->live_url}}" class="btn-form d-none" id="zoom_meeting" data-id="{{$content->id}}">@lang('lang.enter_meeting')</a>
                        </div>
                        <input type="hidden" id="content_id" value="{{$content->type}}">
                        <input type="hidden" id="progress_id" value="{{$content->id}}">
                @else
                    <div class="alert alert-danger text-center">
                        <strong>@lang('lang.zoom_record_comming_soon')</strong>
                    </div>
                    <input type="hidden" id="content_id" value="{{$content->type}}">
                    <input type="hidden" id="progress_id" value="{{$content->id}}">
                @endif
            @else
                <div class="alert alert-danger text-center">
                    <strong>@lang('lang.zoom_record_comming_soon')</strong>
                </div>

            @endif
        @endif
    @endif

@endif


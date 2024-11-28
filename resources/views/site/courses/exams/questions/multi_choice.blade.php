<div class="question_box {{$key == 0 ? 'active' : ''}}" data-name="multi_choice" id="{{$key+1}}">
    <div class="ques_name_box">
        <div class="text-end">
            <h3>@lang('lang.question_no') : {{$key+1}}</h3>
                @if ($question->hint)
                <button type="button" class="explain_btn">
                    <i class="fal fa-question-circle"></i>
                    <span>@lang('lang.question_hint')</span>
                </button>
                @endif
{{--                <button type="button" class="explain_btn" style="pointer-events: none">--}}
{{--                    <span>@lang('lang.degree') : {{$question->degree}} </span>--}}
{{--                </button>--}}

                @if($question->content && $question->content->type == 'homework' && $question->hint_video)
                    <a class="btn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span>@lang('lang.show_video_answer')</span>
                    </a>
                @else
                    @if($question->content && $question->content->type == 'homework' && $question->hint_image)

                        <a data-autoplay="true" data-vbtype="image" href="{{asset($question->hint_image)}}" class="btn venobox" data-fancyboc>
                            <span>@lang('lang.show_video_answer')</span>
                        </a>
                    @endif
                @endif
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <div class="playerH" data-plyr-provider="{{ $question->hint_video_platform }}" data-plyr-embed-id="{{ $question->hint_video_id }}"></div>
                </div>
            </div>
            <div class="ques_explain">
                <p class="" id="explaination_{{$key}}">{!! $question->hint !!}</p>
            </div>
        <div class="name_ques">
            <!--<span class="num">{{$key+1}}</span>-->
            <span class="text ckeditor1 answer_answer" id="ckeditor1"  data-type="multi_choice">{!! $question->question !!}</span>
        </div>
        @if($question->video_url)
            <div class="video_box text-center mt-30">

                @if($question->video_platform == 'youtube')
                    <div class="video_container">
                        <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $question->video_id }}"></div>
                    </div>
{{--                    <iframe width="640" height="480"--}}
{{--                            src="https://www.youtube.com/embed/{{ $question->video_id }}?vq=hd720" frameborder="0"--}}
{{--                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"--}}
{{--                            allowfullscreen></iframe>--}}
                @elseif($question->video_platform == 'vimeo')
                    <div class="video_container">
                        <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $question->video_id }}"></div>
                    </div>
{{--                    <iframe id="course_video_url" data-id="{{$question->id}}"--}}
{{--                            src="https://player.vimeo.com/video/{{ $question->video_id }}?quality=720p"--}}
{{--                            width="640" height="480" frameborder="0"--}}
{{--                            allow="autoplay; fullscreen; picture-in-picture"--}}
{{--                            allowfullscreen></iframe>--}}
                @endif

{{--                <iframe--}}
{{--                    src="https://player.vimeo.com/video/{{ $question->video_url }}?autoplay=1&loop=1"--}}
{{--                    width="640" height="480" frameborder="0"--}}
{{--                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>--}}
            </div>
        @endif
        @if($question->image && !$question->video_url)
            <div class="image text-center mt-30" style="
                    background-image: url({{asset($question->image)}});
                    background-repeat: no-repeat;
                    background-size: contain;
                ">
                <img class="img-thumbnail img-fluid" style="visibility: hidden"  src="{{asset($question->image)}}">
            </div>
        @endif
    </div>
    <div class="question_answers">
        <div class="row">
            <div class="col-md-6">
                <div class="checkStyle-h">
                    <input type="radio" class="d-none required_input_check" value="1" id="ans{{$key}}_{{$key}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[0]}}</span>
                        <label for="ans{{$key}}_{{$key}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text ckeditor1 answer question_ckeditor" id="ckeditor_answer1{{$key}}"  data-type="multi_choice">{!! $question->answer1 !!}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkStyle-h">
                    <input type="radio" class="d-none required_input_check" value="2" id="ans{{$key}}_{{$key+1}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[1]}}</span>
                        <label for="ans{{$key}}_{{$key+1}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text ckeditor1 answer question_ckeditor" id="ckeditor_answer2{{$key}}"  data-type="multi_choice">{!! $question->answer2 !!}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkStyle-h">
                    <input type="radio" class="d-none required_input_check" value="3" id="ans{{$key}}_{{$key+2}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[2]}}</span>
                        <label for="ans{{$key}}_{{$key+2}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text ckeditor1 answer question_ckeditor" id="ckeditor_answer3{{$key}}"  data-type="multi_choice">{!! $question->answer3 !!}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkStyle-h">
                        <input type="radio" class="d-none required_input_check" value="4" id="ans{{$key}}_{{$key+3}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[3]}}</span>
                        <label for="ans{{$key}}_{{$key+3}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text ckeditor1 answer question_ckeditor" id="ckeditor_answer4{{$key}}"  data-type="multi_choice">{!! $question->answer4 !!}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


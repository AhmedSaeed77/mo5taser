<div class="question_box {{$key == 0 ? 'active' : ''}}" data-name="true_false" id="{{$key+1}}">
    <div class="ques_name_box">
        <div class="text-end">
            <h3>@lang('lang.question_no') : {{$key+1}}</h3>
                @if ($question->hint)
                <button type="button" class="explain_btn">
                    <i class="fal fa-question-circle"></i>
                    <span>@lang('lang.question_explaination')</span>
                </button>
                @endif
                <!--<button type="button" class="explain_btn" style="pointer-events: none">
                    <span>@lang('lang.degree') : {{$question->degree}} </span>
                </button>-->

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
            <span class="text ckeditor1 answer_answer" id="ckeditor1" data-type="true_false">{!! $question->question !!}</span>
        </div>

        @if($question->video_platform == 'youtube')
            <div class="mt-30">
                <div class="video_container">
                    <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $question->video_id }}"></div>
                </div>
        @elseif($question->video_platform == 'vimeo')
                    <div class="mt-30">
                        <div class="video_container">
                            <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $question->video_id }}"></div>
                        </div>
        @endif
        @if($question->image && !$question->video_url)
            <div class="image text-center mt-30" style="
                    background-image: url({{asset($question->image)}});
                    background-repeat: no-repeat;
                    background-size: contain;
                ">
                <img class="img-thumbnail img-fluid" style="visibility: hidden" src="{{asset($question->image)}}">
            </div>
        @endif
    </div>
    <div class="question_answers">
        <div class="row">
            <div class="col-md-6">
                <div class="checkStyle-h">
                    <input type="radio" class="d-none required_input_check" value="1" id="quesx_{{$key}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[0]}}</span>
                        <label for="quesx_{{$key}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text">@lang('lang.true')</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkStyle-h">
                        <input type="radio" class="d-none required_input_check" value="0" id="ques_{{$key}}" name="ques_{{$key}}">
                    <div class="single_answer">
                        <span class="num">{{$letters[1]}}</span>
                        <label for="ques_{{$key}}" class="item  flex-center-h">
                            <span class="checkmark"></span>
                            <span class="text">@lang('lang.false')</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

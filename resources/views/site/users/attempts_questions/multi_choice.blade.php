@php
    $answer = \App\Models\StudentAnswer::where([
        'question_id' => $question->id,
        'attemp_id' => $exam->id,
        ])->first();
        if($answer)
    {
        $type = $answer->type;
        $degree = $answer->teacher_degree;
        $student_answer = $answer->student_answer;
    }
    else
    {
        $type = 0;
        $degree = 0;
        $student_answer = 0;
    }

@endphp
<div class="question_wrapper">
    <div class="name_ques">
        <div class="flex-center-h gap-10">
            <span class="num">{{$key + 1}}</span>
            <span class="text">@lang('lang.question_no') : ({{$key + 1}})</span>
            @if($type == 0)
            <span class="result_H error"><i class="fa fa-times"></i></span>
            @endif
            @if($type == 1)
            <span class="result_H correct"><i class="fa fa-check"></i></span>
            @endif
            @if($type == 2)
            <span class="result_H skip"><i class="fa fa-info"></i></span>
            @endif
        </div>
        <span class="icon"><i class="fal fa-plus"></i></span>
    </div>
    <div class="answer_block">
        <div class="question_box active">
            <div class="ques_name_box">
                <div class="text-end">
                    <button type="button" class="explain_btn">

                        <span>@lang('lang.degree') : {{$degree}}/{{$question->degree}}</span>
                    </button>
                </div>
                <div class="name_ques">
                    <span class="num">{{$key+1}}</span>
                    <span class="text ckeditor1 answer" id="ckeditor{{rand(100,10000)}}"  data-type="multi_choice">{!! $question->question !!}</span>
                </div>
                @if($question->video_url)
                    <div class="video_box text-center mt-30">
                        @if($question->video_platform == 'youtube')
                    <div class="video_container">
                        <div class="playerH" data-plyr-provider="youtube" data-plyr-embed-id="{{ $question->video_id }}"></div>
                    </div>
                            <!--<iframe width="640" height="480"
                                    src="https://www.youtube.com/embed/{{ $question->video_id }}?vq=hd720" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
                                   allowfullscreen></iframe>-->
                        @elseif($question->video_platform == 'vimeo')
                    <div class="video_container">
                        <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $question->video_id }}"></div>
                    </div>
                            <!--<iframe id="course_video_url" data-id="{{$question->id}}"
                                    src="https://player.vimeo.com/video/{{ $question->video_id }}?quality=720p"
                                    width="640" height="480" frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture"
                                    allowfullscreen></iframe>-->
                        @endif
{{--                        <iframe--}}
{{--                            src="https://player.vimeo.com/video/{{ $question->video_url }}?autoplay=1&loop=1"--}}
{{--                            width="640" height="480" frameborder="0"--}}
{{--                            allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>--}}
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
                        <div class="single_answer">
                            <div class="item  flex-center-h
                            {{$student_answer == 1 && $question->true_answer != 1 ? 'wrong' : ''}}
                            {{$question->true_answer == 1 ? 'correct' : ''}}
                            ">
                                <span class="checkmark"></span>
                                <span class="text ckeditor1">{!! $question->answer1 !!}</span>
                                @if($question->true_answer == 1)
                                <span class="icon"><i class="fal fa-check-circle"></i></span>
                                @endif
                                @if($student_answer == 1 && $question->true_answer != 1)
                                <span class="icon"><i class="fal fa-times-circle"></i></span>
                                @endif
                                {{--  <span class="icon"><i class="fal fa-times-circle"></i></span>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_answer">
                            <div class="item  flex-center-h
                            {{$student_answer == 2 && $question->true_answer != 2 ? 'wrong' : ''}}
                            {{$question->true_answer == 2 ? 'correct' : ''}}
                            ">
                                <span class="checkmark"></span>
                                <span class="text ckeditor1">{!! $question->answer2 !!}</span>
                                @if($question->true_answer == 2)
                                <span class="icon"><i class="fal fa-check-circle"></i></span>
                                @endif
                                @if($question->true_answer == 2)
                                <span class="icon"><i class="fal fa-check-circle"></i></span>
                                @endif
                                @if($student_answer == 2 && $question->true_answer != 2)
                                <span class="icon"><i class="fal fa-times-circle"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_answer">
                            <div class="item  flex-center-h
                            {{$student_answer == 3 && $question->true_answer != 3 ? 'wrong' : ''}}
                            {{$question->true_answer == 3 ? 'correct' : ''}}
                            ">
                                <span class="checkmark"></span>
                                <span class="text ckeditor1">{!! $question->answer3 !!}</span>
                                @if($question->true_answer == 3)
                                <span class="icon"><i class="fal fa-check-circle"></i></span>
                                @endif
                                @if($student_answer == 3 && $question->true_answer != 3)
                                <span class="icon"><i class="fal fa-times-circle"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single_answer">
                            <div class="item  flex-center-h
                            {{$student_answer == 4 && $question->true_answer != 4 ? 'wrong' : ''}}
                            {{$question->true_answer == 4 ? 'correct' : ''}}
                            ">
                                <span class="checkmark"></span>
                                <span class="text">{!! $question->answer4 !!}</span>
                                @if($question->true_answer == 4)
                                <span class="icon"><i class="fal fa-check-circle"></i></span>
                                @endif
                                @if($student_answer == 4 && $question->true_answer != 4)
                                <span class="icon"><i class="fal fa-times-circle"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($question->hint != NULL || $question->hint_video != NULL || $question->hint_image != NULL)
            <div class="text-center">
                <div class="show_ans close">
                    <span class="d-block">@lang('lang.answer_hint')</span>
                    <i class="transition far fa-chevron-down "></i>
                </div>
            </div>
            <div class="result_box mt-30">
                @if ($question->hint_image != NULL)
                <div class="text-center mb-30">
                    <img width="500" class="img-fluid" src="{{asset($question->hint_image)}}" alt="">
                </div>
                @endif
                @if ($question->question_details != NULL)
                    <div class="text-center">
                        <h5 class="text">@lang('lang.solution')</h5>
                        <span class="text ckeditor1 answer" id="ckeditor{{rand(100,10000)}}"  data-type="multi_choice">{!! $question->question_details !!}</span>
                    </div>
                @endif
                @if ($question->hint_video != NULL)
                    <div class="text-center">
                        <br>
                        @if($question->hint_video_platform == 'youtube')
                            <a class="btn-form vbox-item venobox" data-autoplay="true" data-vbtype="video" href="https://www.youtube.com/embed/{{ $question->hint_video_id }}?vq=hd720">@lang('lang.hint_video')</a>
                        @elseif($question->hint_video_platform == 'vimeo')
                            <a class="btn-form vbox-item venobox" data-autoplay="true" data-vbtype="video" href="https://player.vimeo.com/video/{{ $question->hint_video_id }}?quality=720p">@lang('lang.hint_video')</a>
                        @endif
{{--                        <a class="btn-form vbox-item venobox" data-autoplay="true" data-vbtype="video" href="https://player.vimeo.com/video/{{ $question->hint_video }}?autoplay=1&loop=1">@lang('lang.hint_video')</a>--}}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

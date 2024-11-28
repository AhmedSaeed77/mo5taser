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
                    <span class="text answer" data-type="matching">@lang('lang.match_questions')</span>
                </div>
            </div>
            <div class="question_answers">
                <div class="row">
                    <div class="col-6 connected_questions">
                        <h5 class="main-color mb-20">@lang('lang.questions')</h5>
                        <ul class="list-group">
                            @php
                                $questions = json_decode($answer->student_answer);
                            @endphp
                            @if(sizeOf($questions) > 0)
                                @for ($i=0; $i < sizeOf($questions); $i++)
                                    @php
                                        $match = (array)($questions[$i]);
                                    @endphp
                                    <li class="">
                                        <div class="single_answer">
                                            <label class="item  flex-center-h">
                                                <span class="text">{{$match['q']}}</span>
                                                <input type="radio" class="d-none input_answer" id="" name="ques_4" checked="">
                                            </label>
                                        </div>
                                    </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                    <div class="col-6 connected_answers">
                        <h5 class="mb-20">@lang('lang.answers')</h5>
                        <ul class="list-group">
                            @if(sizeOf($questions) > 0)
                                @for ($i=0; $i < sizeOf($questions); $i++)
                                    @php
                                        $match = (array)($questions[$i]);
                                    @endphp
                                    <li class="{{$match['an'] != $match['qn'] ? 'wrong' : ''}}">
                                        <div class="single_answer">
                                            <div class="item  flex-center-h">
                                                <span class="text">{{$match['a']}}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <div class="show_ans close">
                <span class="d-block">@lang('lang.answer_hint')</span>
                <i class="transition far fa-chevron-down "></i>
            </div>
        </div>
        <div class="result_box mt-30">
            <div class="text-center">
                <h5 class="text">@lang('lang.solution')</h5>
            </div>
            <div class="question_answers ">
                <div class="row ">
                    <div class="col-6 connected_questions ">
                        <h5 class="main-color mb-20 ">@lang('lang.questions')</h5>
                        <ul class="list-group ">
                            @if(sizeOf($questions) > 0)
                                @for ($i=0; $i < sizeOf($questions); $i++)
                                    @php
                                        $match = (array)($questions[$i]);
                                    @endphp
                                    <li class="qu-h">
                                        <div class="single_answer">
                                            <span class="num">{{$match['qn']}}</span>
                                            <label class="item  flex-center-h">
                                                <span class="text">{{$match['q']}}</span>
                                                <input type="radio" class="d-none input_answer" id="" name="ques_4" checked="">
                                            </label>
                                        </div>
                                    </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                    <div class="col-6 connected_answers ">
                        <h5 class="mb-20 ">@lang('lang.answers')</h5>
                        <ul class="list-group ">
                            @if(sizeOf($questions) > 0)
                                @for ($i=0; $i < sizeOf($questions); $i++)
                                    @php
                                        $match = (array)($questions[$i]);
                                    @endphp
                                    <li class="ans-h">
                                        <div class="single_answer">
                                            <span class="num">{{$match['an']}}</span>
                                            <div class="item  flex-center-h">
                                                <span class="text">{{$match['a']}}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endfor
                            @endif
                        </ul>
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

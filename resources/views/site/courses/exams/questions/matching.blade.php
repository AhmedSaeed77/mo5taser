<div class="question_box {{$key == 0 ? 'active' : ''}}" data-name="matching" id="{{$key+1}}">
    <div class="ques_name_box">
        <div class="text-end">
            <h3>@lang('lang.question_no') : {{$key+1}}</h3>
            <!--<button type="button" class="explain_btn">
                {{--  <i class="fal fa-question-circle"></i>  --}}
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
        <div class="name_ques">
            <!--<span class="num">{{$key+1}}</span>-->
            <span class="text answer_answer" data-type="matching">@lang('lang.match_questions')</span>
        </div>
    </div>
    <div class="question_answers connected_section">
        @php
            $questions_macth = json_decode($question->question);
        @endphp
        <div class="row mt-30">
            <div class="col-6 connected_questions">
                <h5 class="main-color mb-20">@lang('lang.questions')</h5>
                <ul class="list-group matching_questions">
                    @if(sizeOf($questions_macth) > 0)
                        @for ($i=0; $i < sizeOf($questions_macth); $i++)
                            @php
                                $match = (array)($questions_macth[$i]);
                            @endphp
                            <li class="">
                                <div class="single_answer">
                                    <label class="item  flex-center-h">
                                        <span class="text" data-num="{{$match['qn']}}">{{$match['q']}}</span>
                                        <input type="radio" class="d-none required_input_check" id="" data-value="{{$match['qn']}}" name="match" checked>
                                    </label>
                                </div>
                            </li>
                        @endfor
                    @endif
                </ul>
            </div>
            <div class="col-6 connected_answers">
                <h5 class="mb-20">@lang('lang.answers')</h5>
                <ul class="list-group list-group-sortable-exclude matching_answers">
                    @if(sizeOf($questions_macth) > 0)
                        @for ($i=0; $i < sizeOf($questions_macth); $i++)
                            @php
                                $match = (array)($questions_macth[$i]);
                            @endphp
                            <li class="li_ans">
                                <div class="single_answer">
                                    <label class="item  flex-center-h">
                                        <span class="text" data-num="{{$match['an']}}">{{$match['a']}}</span>
                                        <input type="radio" class="d-none required_input_check" id="" data-value="{{$match['an']}}" name="match" checked>
                                    </label>
                                </div>
                            </li>
                        @endfor
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

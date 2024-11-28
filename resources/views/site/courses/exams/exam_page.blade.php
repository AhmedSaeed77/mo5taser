@extends('site.includes.master')
@section('css')
    <style>
        .cke_reset_all{
            display: none !important;
        }
        .cke_1.cke.cke_reset.cke_chrome{
            width: 100%;
            pointer-events: none;
        }
        .single_exam_page .settings_box .block .numbers span.skiped {
            background-color: #efb918 !important;
            color: #fff;
        }
        .single_exam_page .settings_box .block .numbers span.done {
            background-color: #29B4E3 !important;
            color: #fff;
        }
        .single_exam_page .settings_box .block .numbers span.active {
            background-color: #ED7565 !important;
            color: #fff;
        }
        .single_exam_page .exam_box .controls_slider #skip {
            background: #efb918;
        }
    </style>
@endsection
@section('content')
<!--========================== Start page header =============================-->
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <span class="current">{{$exam->course->title}}</span>
    </div>
</div>
<!--========================== End page header =============================-->
<!--========================== Start single exam page =============================-->
    <section class="single_exam_page wow animate__animated animate__fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 o-2">
                    <div class="exam_box">
                        <div class="content_box">
                            <form action="{{route('course-exam.submit')}}" method="POST" id="questionForm">
                                @csrf
                                @method('POST')
                                <div class="all_questions">
                                    @foreach ($questions as $key => $question)
                                        <input type="hidden" name="questions[]" value="{{ $question->id }}">
                                        <input type="hidden" name="exam_id" value="{{ $student_exam_id }}">
                                        <input id="qcount" type="hidden" data-qcount="{{ $questions->count() }}" />
                                        @php
                                            if(app()->getLocale() == 'ar')
                                            {
                                                $letters = ['ا', 'ب','چ','د', 'ذ', 'ر', 'ز', 'س', 'ش','ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'ل', 'م', 'ن', 'و', 'ه', 'ی'];
                                            }
                                            if(app()->getLocale() == 'en')
                                            {
                                                $letters = range('A', 'Z');
                                            }
                                        @endphp
                                        @if ($question->type == 'multi_choice')
                                           @include('site.courses.exams.questions.multi_choice')
                                        @elseif ($question->type == 'true_false')
                                           @include('site.courses.exams.questions.true_false')
                                        @elseif ($question->type == 'textual')
                                           @include('site.courses.exams.questions.textual')
                                        @elseif ($question->type == 'matching')
                                           @include('site.courses.exams.questions.matching')
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="true_answers[]" id="true_answers">
                                    <div class="question_box">
                                        <div class="question_answers">
                                            <div class="box_done">
                                                <i class="fas fa-check"></i>
                                                @if($cat)
                                                <p>@lang('lang.move_to_next')</p>
                                                @else
                                                <p>@lang('lang.end_of_exam')</p>
                                                @endif
                                                <button type="submit" class="send-answers main-btn main onceClick" id="send-answer">@lang('lang.send_answers')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="must_answer">
                                    <p class="note">@lang('lang.must_answer')</p>
                                </div>
                                <div class="controls_slider  flex-center-h">
                                    <button type="button" class="main-btn main" id="next">@lang('lang.next')</button>
                                    <button type="button" class="main-btn main" id="skip">@lang('lang.skip')</button>
                                    <button type="button" class="main-btn main" id="prev">@lang('lang.prev')</button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="btn-botton btn-center">
                        <a data-bs-toggle="modal" data-bs-target="#cancelNow" class="btn">
                            @if($cat)
                            <span>@lang('lang.move_to_next')</span>
                            @else
                            <span>@lang('lang.finish_exam')</span>
                            @endif
                        </a>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade cancelNow" id="cancelNow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-cancelNow">
                                    @if($cat)
                                    <h3>@lang('lang.move_to_next')</h3>
                                    @else
                                    <h3>@lang('lang.confirm_finish_exam')</h3>
                                    @endif
                                    <div class="btn-group">
                                        <a class="btn" data-bs-dismiss="modal" aria-label="Close">
                                            <span>@lang('lang.no')</span>
                                        </a>
                                        <button class="btn btn-cancel finish_exam_btn onceClick">
                                            <span>@lang('lang.yes')</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="questions_span">
                        @if($cat)
                        <span class="active">
                            {{$cat->name ?? ''}}
                        </span>
                        @endif
                    </div>
                    <div class="settings_box fixed-box">
                        @if($timer)
                            <div class="head_box  flex-center-h">
                                <h4 class="m-0 main-color">@lang('lang.exam_time')</h4>
                                <div class="timer_exam">
                                    <i class="far fa-clock"></i>
                                    <span class="time quiz-timer" id="safeTimerDisplay"></span>
                                    <input type="hidden" class="timer-number" data-value="{{$timer}}">
                                </div>
                            </div>
                        @endif
                        <div class="block">
                            <h6>@lang('lang.questions') : <span>  {{$questions->count()}}</span></h6>
                            <div class="numbers questions_nums">
                                @for ($i = 0; $i < $questions->count(); $i++)
                                    <span class="{{$i == 0 ? 'active' : ''}}" data-number="{{$i+1}}">{{$i+1}}</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========================== End single exam page =============================-->
@endsection
@section('js')
    @include('site.courses.exams.exam_script')
@endsection

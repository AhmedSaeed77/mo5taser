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
    </style>
@endsection
@section('content')
<!--========================== Start result_of_exam page =============================-->
    <section class="details_of_exam_page">
        <div class="container">
            <div class="content_section wow animate__animated animate__fadeInUp">
                <h5 class="head">@lang('lang.result_of') ({{$exam->content->title}})</h5>
                @php

                    $content = \App\Models\Content::without(\App\Scopes\ActiveScope::class)->where('id',$exam->content_id)->first();
                    $categories = \App\Models\ContentCategory::where('content_id',$content->id)->get();

                    if($content->type == 'split_test')
                    {
                        $questions = \App\Models\Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get();
                    }
                    if($content->type == 'exam' || $content->type == 'homework')
                    {
                        $questions = \App\Models\Question::where('content_id',$exam->content_id)->get();
                    }



                    $right_answers = \App\Models\StudentAnswer::where(['attemp_id' => $exam->id , 'type' => '1'])->get();
                    $wrong_answers = \App\Models\StudentAnswer::where(['attemp_id' => $exam->id , 'type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                        $uncompleted_answers = \App\Models\StudentAnswer::where(['attemp_id' => $exam->id , 'student_answer' => 'not_answered'])->get();
                    if(array_sum($questions->pluck('degree')->toArray()) > 0)
                    {
                        $total = (array_sum($answers->pluck('teacher_degree')->toArray())  / array_sum($questions->pluck('degree')->toArray())) * 100;
                        $total = number_format($total, 2);
                    }
                    else
                    {
                        $total = 0;
                    }
                @endphp
                {{--  @if(($answers->count() == $questions->count()))  --}}
                    @php
                        $finsh_answers = $answers->pluck('type')->toArray();
                    @endphp
                    @if (!in_array(null, $finsh_answers))
                        <div class="result_box">
                            <div class="details row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="box one">
                                        <h6>@lang('lang.total')</h6>
                                        <span class="num">{{floor($total)}} %</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="box two">
                                        <h6>@lang('lang.right_answers')</h6>
                                        <span class="num">{{$right_answers->count()}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 ">
                                    <div class="box three">
                                        <h6>@lang('lang.wrong_answers')</h6>
                                        <span class="num">{{$answers->count() == 0 ? $questions->count() : $wrong_answers->count()}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="box four">
                                        <h6>@lang('lang.uncompleted_answers')</h6>
                                        <span class="num">{{$uncompleted_answers->count()}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="inside">
                                <h6 class="head_small">@lang('lang.subjects_analysis')</h6>
                                <div class="block">
                                    @php
                                        $subjects_ids = $questions->pluck('subject_id')->toArray();
                                        $subjects = \App\Models\Subject::whereIn('id',array_unique($subjects_ids))->get();
                                        $count_subjetcs = array_count_values($subjects_ids);
                                    @endphp
                                    <ul>
                                        @foreach ($subjects as $subject)
                                            @php
                                                $total_subject = $count_subjetcs[$subject->id];
                                                $right_counts_questions = $right_answers->pluck('question_id')->toArray();
                                                $right_count_subjects = \App\Models\Question::whereIn('id',$right_counts_questions)->where('subject_id',$subject->id)->get()->count();
                                                $percent = round($right_count_subjects / $total_subject * 100);
                                            @endphp
                                            <li>{{$subject->name}}  ==>  ({{ $percent }}) %
                                                @if($percent > 0 && $percent <= 65)
                                                    ( <span>@lang('lang.accepted')    </span> )
                                                @elseif($percent > 65 && $percent <= 75)
                                                    ( <span>@lang('lang.good')    </span> )
                                                @elseif($percent > 75 && $percent <= 90)
                                                    ( <span>@lang('lang.very_good')    </span> )
                                                @elseif($percent > 90 && $percent <= 100)
                                                    ( <span>@lang('lang.excellent')    </span> )
                                                @else
                                                    ( <span>@lang('lang.bad')    </span> )
                                                @endif
                                            </li>
                                            <br>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>
                                <div class="text-center">
                                    <a href="{{route('single-course',$content->parent->parent->parent->id)}}" class="btn-form btn-youtube">@lang('lang.back_to_course')</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <b>@lang('lang.not_all_answers')</b>
                        </div>
                    @endif
                {{--  @else
                <div class="alert alert-danger text-center">
                    <b>@lang('lang.uncompleted_attempt')</b>
                </div>
                @endif  --}}

            </div>
        </div>
    </section>
    <!--========================== End result_of_exam page =============================-->


    {{--  @if(($answers->count() == $questions->count()))  --}}
        @php
            $finsh_answers = $answers->pluck('type')->toArray();
        @endphp
        @if (!in_array(null, $finsh_answers))
            <section class="result_of_exam_page">
                <div class="container">
                    <h5 class="headPage">@lang('lang.show_answers')</h5>
                    <div class="content_section">
                        @foreach ($questions as $key => $question)
                            @if ($question->type == 'multi_choice')
                                @include('site.courses.single.attempts_questions.multi_choice')
                            @elseif ($question->type == 'true_false')
                                @include('site.courses.single.attempts_questions.true_false')
                            @elseif ($question->type == 'textual')
                                @include('site.courses.single.attempts_questions.textual')
                            @elseif ($question->type == 'matching')
                                @include('site.courses.single.attempts_questions.matching')
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    {{--  @endif  --}}
    <!--========================== Start result_of_exam page =============================-->

    <!--========================== End result_of_exam page =============================-->
    <input type="hidden" id="lang" value="{{app()->getLocale()}}">

@endsection
@section('js')
    @include('site.exams.exam_script')
    <script>
        var lang = $("#lang").val();
        $(".question_wrapper .show_ans").on('click', function() {
            $(this).parents('.answer_block').find(".result_box").slideToggle();
            $(this).find('i').toggleClass('rotate')
            if ($(this).hasClass('close')) {

                if(lang == 'ar')
                {
                    $(this).find('span').text("عرض أقل")
                }
                else
                {
                    $(this).find('span').text("show less")
                }
                $(this).removeClass('close')
            } else {
                if(lang == 'ar')
                {
                    $(this).find('span').text("عرض الاجابة")
                }
                else
                {
                    $(this).find('span').text("show answer")
                }

                $(this).addClass('close')
            }
        })
    </script>
@endsection

@extends('site.includes.master')
@section('content')

<!--========================== Start result_of_exam page =============================-->
<section class="details_of_exam_page">
    <div class="container">
        @if($content && $content->type == 'split_test')
            @php
                $categories = \App\Models\ContentCategory::where('content_id',$content->id)->get();
                $attempts =  \App\Models\StudentExam::where(['content_id' => $content->id,'status' => 0 , 'user_id' => auth()->id()])->
                whereIn('content_category_id',$categories->pluck('id')->toArray())->orderBy('id','desc')->get();

                $count_attempts = array_values(array_unique($attempts->pluck('attempt')->toArray()));
                //$attempts_count = (int)($attempts->count() / $categories->count());

            @endphp
            @if(sizeof($count_attempts) > 0)
                @for ($i = 0; $i < sizeof($count_attempts); $i++)
                    <div class="content_section wow animate__animated animate__fadeInUp">
                        <h5 class="head">@lang('lang.attempt_no') ({{sizeof($count_attempts) - $i}})</h5>
                        @php
                            $cats_attempt = \App\Models\StudentExam::where([
                            'content_id' => $content->id,
                            'status' => 0 ,
                            'user_id' => auth()->id(),
                            'attempt' => $count_attempts[$i],
                            ])->whereIn('content_category_id',$categories->pluck('id')->toArray())->get();

                            //dd($cats_attempt);

                            $questions = \App\Models\Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get();
                            $answers = \App\Models\StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->get();
                            $right_answers = App\Models\StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where(['type' => '1'])->get();

                            $wrong_answers = App\Models\StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where(['type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                            $uncompleted_answers = App\Models\StudentAnswer::whereIn('attemp_id',$cats_attempt->pluck('id')->toArray())->where('student_answer' , 'not_answered')->get();


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
                        {{--  @if($answers->count() ==  $questions->count())  --}}
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
                                    <br><br>
                                    <div class="text-center">
                                       {{--  <a href="{{route('single.result',$attempt->id)}}" class="btn-form">@lang('lang.show_answers')</a>  --}}
                                       <a href="{{route('single-course',$content->parent->parent->parent->id)}}" class="btn-form btn-youtube">@lang('lang.back_to_course')</a>
                                        <a href="{{route('details-attempts-site' , [$content->id,$count_attempts[$i]])}}" class="btn-form">@lang('lang.show_answers')</a>
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
                    <br>
                @endfor
            @else
            <div class="alert alert-danger text-center">
                <b>@lang('lang.no_attempts')</b>

            </div>
            @endif
        @else
            @if ($attempts->count() > 0)
                @foreach ($attempts as $key => $attempt)
                    <div class="content_section wow animate__animated animate__fadeInUp">
                        <h5 class="head">@lang('lang.attempt_no') ({{$attempts->count() - $key}})</h5>
                        @php

                        $content = \App\Models\Content::without(\App\Scopes\ActiveScope::class)->where('id',$attempt->content_id)->first();
                        $categories = \App\Models\ContentCategory::where('content_id',$content->id)->get();

                        if($content->type == 'split_test')
                        {
                            $questions = \App\Models\Question::whereIn('content_category_id',$categories->pluck('id')->toArray())->get();
                        }
                        if($content->type == 'exam' || $content->type == 'homework')
                        {
                            $questions = \App\Models\Question::where('content_id',$attempt->content_id)->get();
                        }


                        $answers = \App\Models\StudentAnswer::where('attemp_id',$attempt->id)->get();


                            $right_answers = \App\Models\StudentAnswer::where(['attemp_id' => $attempt->id , 'type' => '1'])->get();
                           $wrong_answers = \App\Models\StudentAnswer::where(['attemp_id' => $attempt->id , 'type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                        $uncompleted_answers = \App\Models\StudentAnswer::where(['attemp_id' => $attempt->id , 'student_answer' => 'not_answered'])->get();

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
                        {{--  @if($answers->count() == $questions->count())  --}}
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
                                    <br><br>
                                    <div class="text-center">
                                        <a href="{{route('single-course',$content->parent->parent->parent->id)}}" class="btn-form btn-youtube">@lang('lang.back_to_course')</a>
                                        <a href="{{route('single.result',$attempt->id)}}" class="btn-form">@lang('lang.show_answers')</a>
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
                    <br>
                @endforeach
            @endif
        @endif
    </div>
</section>
<!--========================== End result_of_exam page =============================-->
@endsection
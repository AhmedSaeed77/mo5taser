@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
                                </li>
                                <li>
                                    <a href="{{route('passed-exams.index')}}">@lang('lang.passed_contest_exam')</a>
                                </li>
                                <li>
                                    <a href="{{route('students_attempts',$exam->exam_id)}}">@lang('lang.stuent_attempt')</a>
                                </li>
                                <li class="active">
                                    @lang('lang.show_student_answers')
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.show_student_answers')</b></h4>
                                    {{--  <div class="flex-h flex-hh">
                                        <p>
                                            <span>الدرجة الكلية</span>
                                            <span>200</span>
                                        </p>
                                        <p>
                                            <span>الطالب</span>
                                            <span>60</span>
                                        </p>
                                    </div>  --}}
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.question_type')</th>
                                            <th class="text-center">@lang('lang.degree')</th>
                                            <th class="text-center">@lang('lang.question_subject')</th>
                                            <th class="text-center">@lang('lang.teacher_degree')</th>
                                            <th class="text-center">@lang('lang.answer_type')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($answers->count() > 0)
                                                @foreach ($answers as $key => $answer)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>

                                                        <td class="text-center">{{$answer->question->type}}</td>
                                                        <td class="text-center">{{$answer->question->degree}}</td>
                                                        <td class="text-center">{{$answer->question->subject->name}}</td>
                                                        <td class="text-center">{{$answer->teacher_degree}}</td>
                                                        <td class="text-center">
                                                            @if($answer->type == '0')
                                                                @lang('lang.wrong_answer')
                                                            @endif
                                                            @if($answer->type == '1')
                                                                @lang('lang.true_answer')
                                                            @endif
                                                            @if($answer->type == '2')
                                                                @lang('lang.uncomplete_answer')
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('students_answer',$answer->id)}}" target="_blank">
                                                                <button type="button" class="btn btn-default  waves-effect waves-light" aria-expanded="false">@lang('lang.show_answer')</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->

        </div> <!-- content -->
    </div>
@endsection

@section('js')
    @include('dashboard.includes.datatable_js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
        });
    </script>


@endsection


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
                                <li class="active">
                                    @lang('lang.stuent_attempt')
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.stuent_attempt')</b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.student_name')</th>
                                            {{--  <th class="text-center">@lang('lang.attempt_number')</th>  --}}
                                            <th class="text-center">@lang('lang.main_cat')</th>
                                            <th class="text-center">@lang('lang.level')</th>
                                            <th class="text-center">@lang('lang.total_grade')</th>
                                            <th class="text-center">@lang('lang.student_grade')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($attempts->count() > 0)
                                                @foreach ($attempts as $key => $attempt)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>

                                                        <td class="text-center">{{$attempt->student->name}}</td>
                                                        {{--  <td class="text-center">{{$attempt->attempt}}</td>  --}}
                                                        <td class="text-center">{{$attempt->passExam->mainCat->title}}</td>
                                                        <td class="text-center">{{$attempt->passExam->levelCat->title}}</td>
                                                        @php
                                                            $questions_ids = \App\Models\Question::where('exam_id',$attempt->exam_id)->get()->pluck('id')->toArray();
                                                            $total = array_sum(\App\Models\Question::whereIn('id',$questions_ids)->get()->pluck('degree')->toArray());
                                                            $student_degree = $attempt->studentAnswers->pluck('teacher_degree')->toArray();


                                                            if(in_array(null,$student_degree,true))
                                                            {
                                                                $student_degree_total = __('lang.not_all_answers');
                                                            }
                                                            else
                                                            {
                                                                $student_degree_total = array_sum($student_degree);
                                                            }
                                                        @endphp
                                                        <td class="text-center">{{$total}}</td>
                                                        <td class="text-center">{{$student_degree_total}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('students_answers',$attempt->id)}}">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">@lang('lang.show_student_answers')</button>
                                                            </a>
                                                            <form action="{{route('student_attempt.delete' ,$attempt->id)}}" method="POST" style="display: inline-block;">
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-danger  waves-effect waves-light" aria-expanded="false">@lang('lang.delete')</button>
                                                            </form>

                                                            <button type="button"
                                                                    class="btn btn-info  waves-effect waves-light"
                                                                    aria-expanded="false" data-toggle="modal"
                                                                    data-target="#modelId-{{ $attempt->student->id }}">@lang('lang.send_gift')</button>

                                                            {{--  modal send gift  --}}
                                                            <div class="modal fade message_modal"
                                                                    id="modelId-{{ $attempt->student->id }}" tabindex="-1"
                                                                    role="dialog" aria-labelledby="modelTitleId"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">
                                                                                    @lang('lang.send_to')
                                                                                    <span>{{ $attempt->student->name }}</span>
                                                                                </h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <form action="{{route('send-gift')}}" method="post">
                                                                                @csrf
                                                                                <div class="modal-body">
                                                                                    <div class="form-group"></div>
                                                                                    <textarea class="form-control" name="msg" cols="30" rows="10"
                                                                                        placeholder="@lang('lang.your_gift')" required></textarea>

                                                                                    <input type="hidden" name="user_id" value="{{$attempt->student->id}}"  />
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">@lang('lang.delete')
                                                                                    </button>

                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">@lang('lang.submit')
                                                                                    </button>

                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{--  modal send gift  --}}
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


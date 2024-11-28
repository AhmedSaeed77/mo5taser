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
                                    @lang('lang.passed_exam')
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.questions')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <a href="{{ route('teacher.create.passed', [$teacher_id,$exam_id]) }}">
                                            <button class="btn btn-success waves-effect waves-light">@lang('lang.create')</button>
                                        </a>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.question_type')</th>
                                            <th class="text-center">@lang('lang.degree')</th>
                                            <th class="text-center">@lang('lang.question_subject')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($questions->count() > 0)
                                                @foreach ($questions as $key => $question)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>

                                                        <td class="text-center">{{$question->type}}</td>
                                                        <td class="text-center">{{$question->degree}}</td>
                                                        <td class="text-center">{{$question->subject->name}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('questions.edit' ,$question->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <form action="{{route('questions.destroy' ,$question->id )}}" method="POST" style="display: inline-block;">
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-danger  waves-effect waves-light" aria-expanded="false">@lang('lang.delete')</button>
                                                            </form>
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


@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
							<div class="col-sm-12">
								<ol class="breadcrumb">
									<li>
										<a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
									</li>
									<li>
										<a href="{{route('admin.dashboard')}}">@lang('lang.courses')</a>
									</li>
                                    <li>
										<a href="{{route('course-units',$content->course_id)}}">@lang('lang.units')</a>
									</li>
                                    <li>
                                        <a href="{{route('content-courses.show',$content->parent->parent->id)}}">@lang('lang.course_content')</a>
                                    </li>
									<li class="active">
                                        @lang('lang.stuent_attempt')
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.stuent_attempt')</b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.student_name')</th>
                                            <th class="text-center">@lang('lang.student_degree')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($results->count() > 0)
                                            @foreach ($results as $key => $result)
                                                    @php
                                                        $student_degree = array_sum(\App\Models\StudentAnswer::where('attemp_id',$result->id)->get()->pluck('teacher_degree')->toArray());
                                                        $questions = \App\Models\StudentAnswer::where('attemp_id',$result->id)->get()->pluck('question_id')->toArray();
                                                        $full_mark = array_sum(\App\Models\Question::whereIn('id',$questions)->get()->pluck('degree')->toArray());
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>

                                                        <td class="text-center">{{$result->student->name}}</td>
                                                        <td class="text-center">{{$student_degree }} / {{$full_mark}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('content_answers',$result->id)}}" target="_blank">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">@lang('lang.show_student_answers')</button>
                                                            </a>
                                                            <form action="{{route('content_answers.delete' ,$result->id)}}" method="POST" style="display: inline-block;">
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


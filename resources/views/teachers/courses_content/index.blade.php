@extends('dashboard.includes.app')
@section('css')
    @include('dashboard.includes.datatable')
@endsection
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
										<a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a>
									</li>
									<li>
										<a href="{{route('course-units',$course->id)}}">@lang('lang.units')</a>
									</li>
									<li class="active">
										@lang('lang.unit') -- ({{$unit->title}})
									</li>
								</ol>
							</div>
						</div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.course_content') </b></h4>
                                    <div class="font-13 m-b-30 text-right">

                                        <button class="btn btn-linkedin waves-effect waves-light" data-toggle="modal"
                                            data-target="#section-modal">@lang('lang.section') + </button>

                                        <button class="btn btn-inverse  waves-effect waves-light" data-toggle="modal"
                                            data-target="#lesson-modal">@lang('lang.lesson') + </button>

                                        <button class="btn btn-default waves-effect waves-light" data-toggle="modal"
                                            data-target="#video-modal">@lang('lang.video') + </button>
                                        <a href="#"><button
                                                data-toggle="modal" data-target="#zoom-modal"
                                                class="btn btn-primary waves-effect waves-light">@lang('lang.zoom') +
                                            </button></a>
                                        <a href="#"><button class="btn btn-youtube  waves-effect waves-light"
                                                data-toggle="modal" data-target="#exam-modal">@lang('lang.course_exam') +
                                            </button></a>
                                        <a href="#"><button class="btn btn-info  waves-effect waves-light"
                                                data-toggle="modal" data-target="#split_test">@lang('lang.split_test') +
                                        </button></a>
                                        <a href="#"><button class="btn btn-github  waves-effect waves-light"
                                                data-toggle="modal" data-target="#homework-modal">@lang('lang.homework') +
                                            </button></a>
                                        <a href="#"><button class="btn btn-info  waves-effect waves-light"
                                                data-toggle="modal" data-target="#note-modal">@lang('lang.note') +
                                            </button></a>
                                        <a href="#"><button class="btn btn-success  waves-effect waves-light"
                                                data-toggle="modal" data-target="#attachements-modal">@lang('lang.attachements') +
                                            </button></a>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-switchable="false" class="text-center">#</th>
                                                <th class="text-center">@lang('lang.title_ar')</th>
                                                <th class="text-center">@lang('lang.title_en')</th>
                                                <th class="text-center">@lang('lang.type')</th>
                                                <th class="text-center">@lang('lang.sort')</th>
                                                <th class="text-center">@lang('lang.section')</th>
                                                <th class="text-center">@lang('lang.course')</th>
                                                <th class="text-center">@lang('lang.comments')</th>
                                                <th class="text-center">@lang('lang.students_results')</th>
                                                <th class="text-center">@lang('lang.test_categories')</th>
                                                <th class="text-center">@lang('lang.control')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if ($contents->count() > 0)
                                                @foreach ($contents as $key => $content)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">{{ $content->title_ar }}</td>
                                                        <td class="text-center">{{ $content->title_en }}</td>
                                                        <td class="text-center"><span class="<?php
                                                                if ($content->type == 'video') {
                                                                    echo 'btn btn-default';
                                                                }
                                                                if ($content->type == 'exam') {
                                                                    echo 'btn btn-youtube';
                                                                }
                                                                if ($content->type == 'homework') {
                                                                    echo 'btn btn-github';
                                                                }
                                                                if ($content->type == 'zoom') {
                                                                    echo 'btn btn-primary';
                                                                }
                                                                if ($content->type == 'section') {
                                                                    echo 'btn btn-linkedin';
                                                                }
                                                                if ($content->type == 'lesson') {
                                                                    echo 'btn btn-inverse';
                                                                }
                                                                if ($content->type == 'unit') {
                                                                    echo 'btn btn-info';
                                                                }
                                                                if ($content->type == 'attachement') {
                                                                    echo 'btn btn-success';
                                                                }
                                                                if ($content->type == 'note') {
                                                                    echo 'btn btn-info';
                                                                }
                                                                if ($content->type == 'split_test') {
                                                                    echo 'btn btn-info';
                                                                }
                                                                ?>
                                                                ">@lang('lang.'.$content->type)</span></td>

                                                        <td class="text-center">{{ $content->sort }}</td>
                                                        <td class="text-center">{{ $content->parent->title ?? '' }}</td>
                                                        <td class="text-center">{{ $content->course->title }}</td>
                                                        <td class="text-center">
                                                            @if(!in_array($content->type,['lesson' , 'section']))
                                                            <a href="{{route('content-comments.show',$content->id)}}">
                                                                @lang('lang.comments') - ({{ $content->comments->count() }})
                                                            </a>
                                                            @endif
                                                        </td>

                                                        <td class="text-center">
                                                            @if ($content->type == 'exam' || $content->type == 'homework' || $content->type == 'split_test')
                                                                <a href="{{route('content-results.show',$content->id)}}">
                                                                    <button type="button" class="btn btn-linkedin  waves-effect waves-light" aria-expanded="false">@lang('lang.students_results')</button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($content->type == 'split_test')
                                                                <a href="{{route('content-categories.show',$content->id)}}">
                                                                    <button type="button" class="btn btn-info  waves-effect waves-light" aria-expanded="false">@lang('lang.test_categories')</button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($content->type == 'exam')
                                                                <a href="{{route('content.questions',$content->id)}}">
                                                                    <button type="button" class="btn btn-youtube  waves-effect waves-light" aria-expanded="false">@lang('lang.questions') + </button>
                                                                </a>

                                                            @endif
                                                            @if ($content->type == 'homework')
                                                                <a href="{{route('content.questions',$content->id)}}">
                                                                    <button type="button" class="btn btn-github waves-effect waves-light" aria-expanded="false">@lang('lang.questions') + </button>
                                                                </a>
                                                            @endif
                                                            <a href="{{route('content-courses.edit',$content->id)}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <form action="{{route('content-courses.destroy',$content->id)}}" method="POST" style="display: inline-block;">
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


    {{-- model add section --}}
    <div id="section-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.add_course_section')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post">
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.title_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.section')</label>
                                    <select class="form-control" name="parent_id" required>
                                            <option value="{{$unit->id}}">{{$unit->title}}</option>
                                    </select>
                                </div>
                                <input type="hidden" name="type" value="section">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add section --}}


    {{-- model add lesson --}}
    <div id="lesson-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-inverse">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.add_lesson')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post">
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.title_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.unit')</label>
                                    <select class="form-control" name="parent_id" required>
                                            <option value="{{$unit->id}}">{{$unit->title}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.sort')</label>
                                    <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                           class="form-control sort" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.section')</label>
                                    <select class="form-control" name="parent_id" required>
                                        @if($sections->count() > 0)
                                            @foreach ($sections as $section)
                                                <option value="{{$section->id}}">{{$section->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="hidden" name="type" value="lesson">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add lesson --}}


    {{-- model add video --}}
    <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-success">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.add_course_video')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.name_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.sort')</label>
                                    <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                        class="form-control sort" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.lesson')</label>
                                    <select class="form-control" name="parent_id" required>
                                        @if($lessons->count() > 0)
                                            @foreach ($lessons as $lesson)
                                                <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('lang.video platform')</label>
                                    <select class="form-control" name="video_platform" required>
                                        <option value="youtube">@lang('lang.youtube')</option>
                                        <option value="vimeo">@lang('lang.vimeo')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('lang.video')</label>
                                    <input type="text" name="video_url" placeholder="@lang('lang.video')"
                                        class="form-control" required>
                                </div>

                                <input type="hidden" name="type" value="video">
                                <input type="hidden" name="course_id" value="{{$course->id}}">

                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add video --}}



    {{-- model add note --}}
    <div id="note-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-success">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.add_course_note')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.name_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.sort')</label>
                                    <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                        class="form-control sort" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.lesson')</label>
                                    <select class="form-control" name="parent_id" required>
                                        @if($lessons->count() > 0)
                                            @foreach ($lessons as $lesson)
                                                <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('lang.desc_ar')</label>
                                    <textarea type="text" name="desc_ar" placeholder="@lang('lang.desc_ar')"
                                        class="form-control" rows="4" required>{{old('desc_ar')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.desc_en')</label>
                                    <textarea type="text" name="desc_en" placeholder="@lang('lang.desc_en')"
                                        class="form-control" rows="4" required>{{old('desc_en')}}</textarea>
                                </div>

                                <input type="hidden" name="type" value="note">
                                <input type="hidden" name="course_id" value="{{$course->id}}">

                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add note --}}

    {{-- model add exam --}}
    <div id="exam-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-danger">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.course_exam')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_ar')</label>
                                            <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                                class="form-control title_ar" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_en')</label>
                                            <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                                class="form-control title_en" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_ar')</label>
                                            <textarea name="instructions_ar" rows="3"
                                                placeholder="@lang('lang.instructions_ar')"
                                                class="form-control ckeditor">{{ old('instructions_ar') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_en')</label>
                                            <textarea name="instructions_en" rows="3"
                                                placeholder="@lang('lang.instructions_en')"
                                                class="form-control ckeditor">{{ old('instructions_en') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.activation')</label>
                                            <select class="form-control" name="active" required>
                                                <option value="0">@lang('lang.not_active')</option>
                                                <option value="1">@lang('lang.active')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.attemps')</label>
                                            <input type="number" min="1" name="attempts_count" placeholder="@lang('lang.attemps')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.sort')</label>
                                            <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.questions_number')</label>
                                            <input type="number" min="1" name="questions_number"
                                                placeholder="@lang('lang.questions_number')" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.exam_time')</label>
                                            <input type="number" min="1" name="exam_time"
                                                placeholder="@lang('lang.exam_time')" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('lang.lesson')</label>
                                        <select class="form-control" name="parent_id" required>
                                            @if($lessons->count() > 0)
                                                @foreach ($lessons as $lesson)
                                                    <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    </div>
                                </div>


                                <input type="hidden" name="type" value="exam">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add exam --}}

    {{-- model add exam --}}
    <div id="split_test" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-danger">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.split_test')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_ar')</label>
                                            <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                                class="form-control title_ar" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_en')</label>
                                            <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                                class="form-control title_en" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_ar')</label>
                                            <textarea name="instructions_ar" rows="3"
                                                placeholder="@lang('lang.instructions_ar')"
                                                class="form-control ckeditor">{{ old('instructions_ar') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_en')</label>
                                            <textarea name="instructions_en" rows="3"
                                                placeholder="@lang('lang.instructions_en')"
                                                class="form-control ckeditor">{{ old('instructions_en') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.activation')</label>
                                            <select class="form-control" name="active" required>
                                                <option value="0">@lang('lang.not_active')</option>
                                                <option value="1">@lang('lang.active')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.attemps')</label>
                                            <input type="number" min="1" name="attempts_count" placeholder="@lang('lang.attemps')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.sort')</label>
                                            <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.exam_time')</label>
                                            <input type="number" min="1" name="exam_time"
                                                placeholder="@lang('lang.exam_time')" class="form-control" required>
                                        </div>
                                    </div>  --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.lesson')</label>
                                            <select class="form-control" name="parent_id" required>
                                                @if($lessons->count() > 0)
                                                    @foreach ($lessons as $lesson)
                                                        <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="type" value="split_test">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add exam --}}


    {{-- model add zoom --}}
    <div id="zoom-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.zoom')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.title_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.sort')</label>
                                    <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                        class="form-control sort" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.live_url')</label>
                                    <input type="url" name="live_url" placeholder="@lang('lang.live_url')"
                                        class="form-control">
                                    <span style="color: red">@lang('lang.optional')</span>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.recorded platform')</label>
                                    <select class="form-control" name="recorded_platform" required>
                                        <option value="youtube">@lang('lang.youtube')</option>
                                        <option value="vimeo">@lang('lang.vimeo')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.recorded_url')</label>
                                    <input type="url" name="recorded_url" placeholder="@lang('lang.recorded_url')"
                                        class="form-control" >
                                        <span style="color: red">@lang('lang.optional')</span>
                                </div>
                                {{--  <div class="form-group">
                                    <label>@lang('lang.zoom_date')</label>
                                    <input type="date" name="zoom_date"
                                        placeholder="@lang('lang.zoom_date')" class="form-control" required>
                                </div>  --}}
                                <div class="form-group">
                                    <label>@lang('lang.zoom_time')</label>
                                    <input type="datetime-local" name="zoom_time"
                                        placeholder="@lang('lang.zoom_time')" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.lesson')</label>
                                    <select class="form-control" name="parent_id" required>
                                        @if($lessons->count() > 0)
                                            @foreach ($lessons as $lesson)
                                                <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="hidden" name="type" value="zoom">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add zoom --}}


    {{-- model add homework --}}
    <div id="homework-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.homework')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype=multipart/form-data>
                                @csrf
                                {{ method_field('POST') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_ar')</label>
                                            <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                                class="form-control title_ar" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.title_en')</label>
                                            <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                                class="form-control title_en" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_ar')</label>
                                            <textarea name="instructions_ar" rows="3"
                                                placeholder="@lang('lang.instructions_ar')"
                                                class="form-control ckeditor">{{ old('instructions_ar') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('lang.instructions_en')</label>
                                            <textarea name="instructions_en" rows="3"
                                                placeholder="@lang('lang.instructions_en')"
                                                class="form-control ckeditor">{{ old('instructions_en') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.activation')</label>
                                            <select class="form-control" name="active" required>
                                                <option value="0">@lang('lang.not_active')</option>
                                                <option value="1">@lang('lang.active')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.sort')</label>
                                            <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.attemps')</label>
                                            <input type="number" min="1" name="attempts_count" placeholder="@lang('lang.attemps')"
                                                class="form-control sort" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.questions_number')</label>
                                            <input type="number" min="1" name="questions_number"
                                                placeholder="@lang('lang.questions_number')" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.lesson')</label>
                                            <select class="form-control" name="parent_id" required>
                                                @if($lessons->count() > 0)
                                                    @foreach ($lessons as $lesson)
                                                        <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="homework">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add homework --}}
    {{-- model add homework --}}
    <div id="attachements-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.attachements')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('POST') }}

                                <div class="form-group">
                                    <label>@lang('lang.title_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.activation')</label>
                                    <select class="form-control" name="active" required>
                                        <option value="0">@lang('lang.not_active')</option>
                                        <option value="1">@lang('lang.active')</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.sort')</label>
                                    <input type="number" min="1" name="sort" placeholder="@lang('lang.sort')"
                                        class="form-control sort" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.file')</label>
                                    <input type="file" name="attachement" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.lesson')</label>
                                    <select class="form-control" name="parent_id" required>
                                        @if($lessons->count() > 0)
                                            @foreach ($lessons as $lesson)
                                                <option value="{{$lesson->id}}">{{$lesson->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('lang.download')</label>
                                    <select class="form-control" name="download" required>
                                        <option value="0">@lang('lang.no')</option>
                                        <option value="1">@lang('lang.yes')</option>
                                    </select>
                                </div>
                                <input type="hidden" name="type" value="attachement">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add homework --}}
@endsection

@section('js')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
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
    <script>
        CKEDITOR.replace('markdownckeditor');
    </script>
@endsection



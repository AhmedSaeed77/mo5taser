@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')

@section('css')
<link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
    type="text/css" />

@endsection

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
                                    <a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a>
                                </li>
                                <li>
                                    <a href="{{route('course-units',$content->course_id)}}">@lang('lang.units')</a>
                                </li>
                                @if($content->type == 'unit')
                                    <li>
                                        <a href="{{route('content-courses.show',$content->id)}}">@lang('lang.course_content')</a>
                                    </li>
                                @elseif($content->type == 'section')
                                    <li>
                                        <a href="{{route('content-courses.show',$content->parent->id)}}">@lang('lang.course_content')</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{route('content-courses.show',$content->parent->parent->id)}}">@lang('lang.course_content')</a>
                                    </li>
                                @endif
                                <li class="active">
                                    @lang('lang.edit') -- ({{$content->title}})
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>@lang('lang.edit') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('content-courses.update',$content) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>@lang('lang.title_ar')</label>
                                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                                        class="form-control title_ar" value="{{$content->title_ar}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('lang.title_en')</label>
                                                    <input type="text" name="title_en" value="{{$content->title_en}}" placeholder="@lang('lang.title_en')"
                                                        class="form-control title_en" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('lang.activation')</label>
                                                    <select class="form-control" name="active" required>
                                                        <option value="0" {{$content->active == 0 ? 'selected' : ''}}>@lang('lang.not_active')</option>
                                                        <option value="1" {{$content->active == 1 ? 'selected' : ''}}>@lang('lang.active')</option>
                                                    </select>
                                                </div>
                                                @if($content->type == 'section')
                                                <div class="form-group">
                                                    <label>@lang('lang.section')</label>
                                                    <select class="form-control" name="parent_id" required>
                                                        @foreach ($units as $unit)
                                                            <option value="{{$unit->id}}" {{$unit->id == $content->parent_id ? 'selected' : ''}}>{{$unit->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                                @if($content->type == 'lesson')
                                                <div class="form-group">
                                                    <label>@lang('lang.section')</label>
                                                    <select class="form-control" name="parent_id" required>
                                                        @foreach ($sections as $section)
                                                            <option value="{{$section->id}}" {{$section->id == $content->parent_id ? 'selected' : ''}}>{{$section->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('lang.sort')</label>
                                                    <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                           class="form-control sort" required>
                                                </div>
                                                @endif
                                                @if($content->type == 'unit')
                                                <div class="form-group">
                                                    <label>@lang('lang.file')</label>
                                                    <input type="file" name="image" accept="image/*" class="form-control" >
                                                    <span style="color:red">@lang('lang.optional')</span>
                                                    <div>
                                                        <img src="{{asset($content->image)}}" style="width: 80px; height: 80px;">
                                                    </div>
                                                </div>
                                                @endif
                                                @if($content->type == 'video')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                                @foreach ($lessons as $lesson)
                                                                    <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.video platform')</label>
                                                        <select class="form-control" name="video_platform" required>
                                                            <option value="youtube" {{$content->video_platform == 'youtube' ? 'selected' : ''}}>@lang('lang.youtube')</option>
                                                            <option value="vimeo" {{$content->video_platform == 'vimeo' ? 'selected' : ''}}>@lang('lang.vimeo')</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.video')</label>
                                                        <input type="text" name="video_url" value="{{$content->video_url}}" placeholder="@lang('lang.video')"
                                                            class="form-control" required>
                                                    </div>
                                                @endif
                                                @if($content->type == 'note')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                                @foreach ($lessons as $lesson)
                                                                    <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.desc_ar')</label>
                                                        <textarea type="text" name="desc_ar" placeholder="@lang('lang.desc_ar')"
                                                            class="form-control" rows="4" required>{{$content->desc_ar}}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.desc_en')</label>
                                                        <textarea type="text" name="desc_en" placeholder="@lang('lang.desc_en')"
                                                            class="form-control" rows="4" required>{{$content->desc_en}}</textarea>
                                                    </div>

                                                @endif
                                                @if($content->type == 'zoom')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                            @foreach ($lessons as $lesson)
                                                                <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.live_url')</label>
                                                        <input type="url" name="live_url" value="{{$content->live_url}}" placeholder="@lang('lang.live_url')"
                                                            class="form-control">
                                                        <span style="color: red">@lang('lang.optional')</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.recorded platform')</label>
                                                        <select class="form-control" name="recorded_platform" required>
                                                            <option value="youtube" {{$content->recorded_platform == 'youtube' ? 'selected' : ''}}>@lang('lang.youtube')</option>
                                                            <option value="vimeo" {{$content->recorded_platform == 'vimeo' ? 'selected' : ''}}>@lang('lang.vimeo')</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.recorded_url')</label>
                                                        <input type="url" name="recorded_url" value="{{$content->recorded_url}}"  placeholder="@lang('lang.recorded_url')"
                                                            class="form-control" >
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.zoom_time')</label>
                                                        <input type="datetime-local"
                                                        value="<?php echo date("c", strtotime($content->zoom_time)); ?>"
                                                        name="zoom_time"
                                                        placeholder="@lang('lang.zoom_time')" class="form-control" >
                                                        <br>
                                                        <h3 style="color: #000"> @lang('lang.zoom_time')  / {{$content->zoom_time}} </h3>
                                                    </div>
                                                @endif

                                                @if($content->type == 'exam' || $content->type == 'split_test' || $content->type == 'homework')
                                                    <div class="form-group">
                                                        <label>@lang('lang.instructions_ar')</label>
                                                        <textarea name="instructions_ar" rows="3"
                                                            placeholder="@lang('lang.instructions_ar')"
                                                            class="form-control ckeditor">{{$content->instructions_ar }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.instructions_en')</label>
                                                        <textarea name="instructions_en" rows="3"
                                                            placeholder="@lang('lang.instructions_en')"
                                                            class="form-control ckeditor">{{$content->instructions_en }}</textarea>
                                                    </div>
                                                @endif
                                                @if($content->type == 'exam')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                            @foreach ($lessons as $lesson)
                                                                <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.attemps')</label>
                                                        <input type="number" min="1" name="attempts_count" value="{{$content->attempts_count}}" placeholder="@lang('lang.attemps')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.questions_number')</label>
                                                        <input type="number" min="1" value="{{$content->questions_number}}" name="questions_number"
                                                            placeholder="@lang('lang.questions_number')" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.exam_time')</label>
                                                        <input type="number" value="{{$content->exam_time}}" min="1" name="exam_time"
                                                            placeholder="@lang('lang.exam_time')" class="form-control" required>
                                                    </div>
                                                @endif
                                                @if($content->type == 'split_test')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                            @foreach ($lessons as $lesson)
                                                                <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                            @endforeach
                                                        @endif
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.attemps')</label>
                                                        <input type="number" min="1" name="attempts_count" value="{{$content->attempts_count}}" placeholder="@lang('lang.attemps')"
                                                            class="form-control sort" required>
                                                    </div>
                                                    {{--  <div class="form-group">
                                                        <label>@lang('lang.exam_time')</label>
                                                        <input type="number" value="{{$content->exam_time}}" min="1" name="exam_time"
                                                            placeholder="@lang('lang.exam_time')" class="form-control" required>
                                                    </div>  --}}
                                                @endif
                                                @if($content->type == 'homework')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                        @if($lessons->count() > 0)
                                                                @foreach ($lessons as $lesson)
                                                                    <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.attemps')</label>
                                                        <input type="number" min="1" name="attempts_count" value="{{$content->attempts_count}}" placeholder="@lang('lang.attemps')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.questions_number')</label>
                                                        <input type="number" min="1" value="{{$content->questions_number}}" name="questions_number"
                                                            placeholder="@lang('lang.questions_number')" class="form-control" required>
                                                    </div>
                                                @endif
                                                @if($content->type == 'attachement')
                                                    <div class="form-group">
                                                        <label>@lang('lang.lesson')</label>
                                                        <select class="form-control" name="parent_id" required>
                                                            @if($lessons->count() > 0)
                                                                @foreach ($lessons as $lesson)
                                                                    <option value="{{$lesson->id}}" {{$lesson->id == $content->parent_id ? 'selected' : ''}}>{{$lesson->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('lang.file')</label>
                                                        <input type="file" name="attachement" class="form-control" >
                                                        <span style="color:red">@lang('lang.optional')</span>
                                                        <div class="pull-right">
                                                            <a href="{{asset($content->attachement)}}" target="_blank" >@lang('lang.show_file')</a>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.sort')</label>
                                                        <input type="number" min="1" value="{{$content->sort}}" name="sort" placeholder="@lang('lang.sort')"
                                                            class="form-control sort" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>@lang('lang.download')</label>
                                                        <select class="form-control" name="download" required>
                                                            <option value="0" {{$content->download == 0 ? 'selected' : ''}}>@lang('lang.no')</option>
                                                            <option value="1" {{$content->download == 1 ? 'selected' : ''}}>@lang('lang.yes')</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer pull-right">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.edit')</button>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>
    <script>
        CKEDITOR.replace('markdownckeditor');
    </script>
@endsection

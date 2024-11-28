@extends('dashboard.includes.app')

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
										<a href="{{route('course-units',$content->course_id)}}">@lang('lang.units')</a>
									</li>
									<li>
										<a href="{{route('content-courses.show',$content->parent->parent->id)}}">@lang('lang.course_content')</a>
									</li>
									<li>
										<a href="{{route('content-comments.show',$content->id)}}">@lang('lang.comments')</a>
									</li>
									<li class="active">
                                        @lang('lang.replies')
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>@lang('lang.replies') </h4>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            @if ($comments->count() > 0)
                                                @foreach ($comments as $comment)
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-default panel-border">
                                                            <div class="panel-heading">
                                                                @if($comment->user)
                                                                <h3 class="panel-title">{{$comment->user->name}}  ({{$comment->created_at->format('Y-m-d')}})</h3>
                                                                @endif
                                                                @if($comment->teacher)
                                                                <h3 class="panel-title">{{$comment->teacher->name}}  ({{$comment->created_at->format('Y-m-d')}})</h3>
                                                                @endif
                                                            </div>
                                                            <div class="panel-body">
                                                                <p>{{$comment->comment}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <form action="{{route('content-comments.store')}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.comment')</label>
                                                            <textarea class="form-control" id="field-1" name="comment"
                                                            placeholder="@lang('lang.comment')" required>{{old('comment')}}</textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="content_id" value="{{$content->id}}">
                                                    <input type="hidden" name="parent_id" value="{{$master_comment->id}}">
                                                </div>
                                            <div class="modal-footer pull-right">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.add_comment')</button>
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

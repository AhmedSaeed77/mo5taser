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
										<a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a>
									</li>
									<li>
										<a href="{{route('course-units',$content->course_id)}}">@lang('lang.units')</a>
									</li>
									<li>
										<a href="{{route('content-courses.show',$content->parent->parent->id)}}">@lang('lang.course_content')</a>
									</li>
									<li class="active">
                                        @lang('lang.comments')
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.comments')</b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.comment')</th>
                                            <th class="text-center">@lang('lang.user')</th>
                                            <th class="text-center">@lang('lang.content')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($comments->count() > 0)
                                                @foreach ($comments as $key => $comment)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">
                                                            {!! \Illuminate\Support\Str::limit($comment->comment) !!}
                                                        <td class="text-center">{{$comment->user->name ?? ''}}</td>
                                                        <td class="text-center">{{$content->title}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('content-comments.edit' ,$comment->id )}}">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">({{$comment->childs->count()}}) @lang('lang.replies')</button>
                                                            </a>

                                                            <button class="btn btn-danger modal_btn" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            data-id="{{$comment->id}}"> @lang('lang.delete') </button>

                                                            {{--  modal  --}}
                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('content-comments.destroy',$comment->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                                <div class="modal-body text-center">
                                                                                    <div class="alert alert-danger">
                                                                                    <h3>@lang('lang.confirm_delete')</h3>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"> @lang('lang.close') </button>
                                                                                    <button type="submit" class="btn btn-danger pull-right"> @lang('lang.delete') </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

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


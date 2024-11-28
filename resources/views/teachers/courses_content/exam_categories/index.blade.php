@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('style')
<style>
    .form-inline .edit-modal .form-group .control-label {
        max-width: 33%;
        flex: 0 0 33%;
    }

    .form-inline .edit-modal .form-group {
        display: flex;
        flex-wrap: wrap;
        margin: 10px 0;
        align-items: center;
        -webkit-align-items: center;
    }

    .form-inline .edit-modal .form-group .form-control {
        max-width: 67%;
        flex: 0 0 67%;
    }

    .modal-footer {}

    .form-inline .edit-modal .modal-footer {
        display: flex;
        /* justify-content: space-between; */
    }
</style>
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
									<li class="active">
                                        @lang('lang.exam_categories')
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.categories_with') -- {{$content->title}} </b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title_ar')</th>
                                            <th class="text-center">@lang('lang.title_en')</th>
                                            <th class="text-center">@lang('lang.questions_number')</th>
                                            <th class="text-center">@lang('lang.slug')</th>
                                            <th class="text-center">@lang('lang.questions')</th>
                                            <th class="text-center">@lang('lang.exam_time')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $key => $category)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$category->name_ar}}</td>
                                                        <td class="text-center">{{$category->name_en}}</td>
                                                        <td class="text-center">{{$category->questions_number}}</td>
                                                        <td class="text-center">{{$category->content->title ?? '--'}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('content-categories-questions.show',$category->id)}}">
                                                                <button type="button" class="btn btn-youtube  waves-effect waves-light" aria-expanded="false">@lang('lang.questions') + </button>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">{{$category->exam_time}}</td>
                                                        <td class="text-center">

                                                            <button class="btn btn-success modal_btn" alt="default" data-toggle="modal" data-target="#edit-modal{{$key}}"
                                                            > @lang('lang.edit') </button>


                                                            {{--  modal edit   --}}
                                                            <div id="edit-modal{{$key}}" class="modal edit-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.edit')</h4>
                                                                        </div>
                                                                        <form action="{{route('content-categories.update',$category->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                                                                            <input type="text" class="form-control" id="field-1"name="name_ar"
                                                                                            placeholder="@lang('lang.title_ar')" required value="{{ $category->name_ar }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                                                                            <input type="text" class="form-control" id="field-1"name="name_en"
                                                                                            placeholder="@lang('lang.title_en')" required value="{{ $category->name_en }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="field-1" class="control-label">@lang('lang.questions_number')</label>
                                                                                            <input type="number" class="form-control" id="field-1"name="questions_number"
                                                                                            placeholder="@lang('lang.questions_number')" required value="{{ $category->questions_number }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="field-1" class="control-label">@lang('lang.exam_time')</label>
                                                                                            <input type="number" value="{{$category->exam_time}}" min="1" name="exam_time"
                                                                                                placeholder="@lang('lang.exam_time')" class="form-control" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="content_id" value="{{$content->id}}">
                                                                            </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"> @lang('lang.close') </button>
                                                                                    <button type="submit" class="btn btn-danger pull-right"> @lang('lang.update') </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <button class="btn btn-danger modal_btn" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            > @lang('lang.delete') </button>
                                                            {{--  modal  --}}
                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('content-categories.destroy',$category->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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

    {{--  modal  --}}
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('lang.create')</h4>
                </div>
                <form action="{{ route('content-categories.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                    <input type="text" class="form-control" id="field-1"name="name_ar"
                                    placeholder="@lang('lang.title_ar')" required value="{{ old('name_ar') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                    <input type="text" class="form-control" id="field-1"name="name_en"
                                    placeholder="@lang('lang.title_en')" required value="{{ old('name_en') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.questions_number')</label>
                                    <input type="number" class="form-control" id="field-1"name="questions_number"
                                    placeholder="@lang('lang.questions_number')" required value="{{ old('questions_number') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('lang.exam_time')</label>
                                    <input type="number" min="1" name="exam_time"
                                        placeholder="@lang('lang.exam_time')" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="content_id" value="{{$content->id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('lang.close')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  modal  --}}



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


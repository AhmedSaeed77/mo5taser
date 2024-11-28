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
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.courses')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <a href="{{route('courses.create')}}">
                                            <button class="btn btn-success waves-effect waves-light">@lang('lang.create')</button>
                                        </a>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title')</th>
                                            {{--  <th class="text-center">@lang('lang.category')</th>  --}}
                                            <th class="text-center">@lang('lang.price')</th>
                                            {{--  <th class="text-center">@lang('lang.price_after')</th>  --}}
                                            <th class="text-center">@lang('lang.activation')</th>
                                            <th class="text-center">@lang('lang.q_a')</th>
                                            <th class="text-center">@lang('lang.students_results')</th>
                                            <th class="text-center">@lang('lang.ratings')</th>
                                            <th class="text-center">@lang('lang.progress')</th>
                                            <th class="text-center">@lang('lang.copy_content')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($courses->count() > 0)
                                                @foreach ($courses as $key => $course)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$course->title}}</td>
                                                        {{--  <td class="text-center">{{$course->category->title}}</td>  --}}
                                                        <td class="text-center">{{$course->price}}</td>
                                                        {{--  <td class="text-center">{{$course->price_after}}</td>  --}}
                                                        <td class="text-center">{{$course->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                                                        <td class="text-center"><a href="{{route('question_answer.show',$course->id)}}">@lang('lang.q_a')</a></td>
                                                        <td class="text-center"><a href="{{route('students_results.show',$course->id)}}">@lang('lang.students_results')</a></td>
                                                        <td class="text-center"><a href="{{route('rating.show',$course->id)}}">@lang('lang.ratings') ({{$course->ratingCount()}})</a></td>
                                                        <td class="text-center"><a href="{{route('students-progress.show',$course->id)}}">@lang('lang.progress')</a></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-info modal_btn" alt="default" data-toggle="modal" data-target="#copy-modal{{$key}}"
                                                            data-id="{{$course->id}}"> @lang('lang.copy_content') </button>

                                                            {{--  modal  --}}
                                                            <div id="copy-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.copy_content')</h4>
                                                                        </div>
                                                                        <form action="{{route('copy_content',$course->id)}}" method="POST" enctype="multipart/form-data" >
                                                                            @csrf
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="col-md-12">
                                                                                                <label for="field-1" class="control-label">@lang('lang.course')</label>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <select class="form-control" name="course_select" required>
                                                                                                    <option value="">@lang('lang.choose')</option>
                                                                                                    @if($courses->count() > 0)
                                                                                                        @foreach ($courses as $item)
                                                                                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"> @lang('lang.close') </button>
                                                                                    <button type="submit" class="btn btn-info pull-right"> @lang('lang.copy_content') </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">

                                                            <a href="{{route('free-subscribe.show' ,$course->id )}}">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">@lang('lang.free_subscribe')</button>
                                                            </a>

                                                            <a href="{{route('courses.edit' ,$course->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger modal_btn" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            data-id="{{$course->id}}"> @lang('lang.delete') </button>

                                                            {{--  modal  --}}
                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('courses.destroy' ,$course->id )}}" method="POST" enctype="multipart/form-data" id="userForm">
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
        $(document).ready(function(){
            $('.modal_btn').on('click', function (event) {
                var id = $(this).data('id');
                $('#userForm').attr("action", "{{ url('/admin/courses') }}" + "/" + id);
            })
        });
    </script>
@endsection


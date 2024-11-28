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
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.subscribes')</b></h4>

                                    <form action="{{route('admin.filter', 'course')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">@lang('lang.course')</label>
                                                    <select class="form-control" name="course_id">
                                                        <option value="">------</option>
                                                        @foreach($courses as $course)
                                                            <option {{ $data['course_id'] == $course->id ? 'selected' : '' }} value="{{ $course->id }}">{{ $course->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">@lang('lang.range')</label>
                                                    <select class="form-control" name="range">
                                                        <option {{ $data['range'] == 'all' ? 'selected' : '' }} value="all" {{request()->key == 'all' ? 'selected' : ''}}>@lang('lang.all')</option>
                                                        <option {{ $data['range'] == 'active' ? 'selected' : '' }} value="active" {{request()->key == 'active' ? 'selected' : ''}}>@lang('lang.active')</option>
                                                        <option {{ $data['range'] == 'ended' ? 'selected' : '' }} value="ended" {{request()->key == 'ended' ? 'selected' : ''}}>@lang('lang.ended')</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-top: 27px;">@lang('lang.search')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="font-13 m-b-30 text-right">
                                        <form action="{{ route('admin.filter.export', 'course') }}" method="post">
                                            @csrf
                                            <input name="data" type="hidden" value="{{ $export_subscribes }}">
                                            <button class="btn btn-info waves-effect waves-light" type="submit">@lang('lang.excell_export')</button>
                                        </form>
{{--                                        <a href="{{route('subscribe-exports')}}">--}}
{{--                                        </a>--}}
                                    </div>
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.course')</th>
                                            <th class="text-center">@lang('lang.user')</th>
                                            <th class="text-center">@lang('lang.image')</th>
                                            <th class="text-center">@lang('lang.total')</th>
                                            <th class="text-center">@lang('lang.activation')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($subscribes->count() > 0)
                                            @foreach ($subscribes as $key => $subscribe)
                                                <tr>
                                                    <td class="text-center">{{$key + 1}}</td>
                                                    <td class="text-center">{{$subscribe->course->title}}</td>
                                                    <td class="text-center">{{$subscribe->user->name}}</td>
                                                    <td class="text-center">
                                                        @if($subscribe->user->image !== null)
                                                            <img src="{{url($subscribe->user->image)}}" style="width: 80px; height: 80px; border-radius: 50%">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{$subscribe->total}}</td>
                                                    <td class="text-center">{{$subscribe->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('subscribes.edit' ,$subscribe->id )}}">
                                                            <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                        </a>

                                                        <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                data-id="{{$subscribe->id}}"> @lang('lang.delete') </button>

                                                        <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                    </div>
                                                                    <form action="{{route('subscribes.destroy',$subscribe->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                                <div>
                                    @if ($subscribes->count() > 0)
                                        {{$subscribes->appends(request()->query())->links()}}
                                    @endif
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

{{--  @section('js')
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
                $('#userForm').attr("action", "{{ url('/admin/subscribes') }}" + "/" + id);
            })
        });
    </script>
@endsection  --}}


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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.subjects')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.name_ar')</th>
                                            <th class="text-center">@lang('lang.name_en')</th>
                                            <th class="text-center">@lang('lang.parent')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($subjects->count() > 0)
                                                @foreach ($subjects as $key => $subject)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$subject->name_ar}}</td>
                                                        <td class="text-center">{{$subject->name_en}}</td>
                                                        <td class="text-center">{{$subject->parent->name ?? '--'}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('subject.edit' ,$subject->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <button class="btn btn-danger " alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$subject->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('subject.destroy',$subject->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                <form action="{{ route('subject.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.name_ar')</label>
                                    <input type="text" class="form-control" id="field-1" name="name_ar"
                                    placeholder="@lang('lang.name_ar')" required value="{{ old('name_ar') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.name_en')</label>
                                    <input type="text" class="form-control" id="field-1" name="name_en"
                                    placeholder="@lang('lang.name_en')" required value="{{ old('name_en') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.belongsTo')</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="">@lang('lang.parent_cat')</option>
                                        @if($subjects->count() > 0)
                                            @foreach ($subjects as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('lang.close')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
                    </div>
                </form>
            </div>
        </div>
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


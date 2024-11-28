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
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>@lang('lang.team_edit') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('team.update',$team) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.name_ar')</label>
                                                            <input type="text" class="form-control" id="field-1"name="name_ar"
                                                            placeholder="@lang('lang.name_ar')" required value="{{$team->name_ar }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.name_en')</label>
                                                            <input type="text" class="form-control" id="field-1"name="name_en"
                                                            placeholder="@lang('lang.name_en')" required value="{{$team->name_en }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.job_ar')</label>
                                                            <input type="text" class="form-control" id="field-1"name="job_ar"
                                                            placeholder="@lang('lang.job_ar')" required value="{{$team->job_ar }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.job_en')</label>
                                                            <input type="text" class="form-control" id="field-1"name="job_en"
                                                            placeholder="@lang('lang.job_en')" required value="{{$team->job_en }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($team->image)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                </div>
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
    <script>
        CKEDITOR.replace('markdownckeditor');
    </script>
@endsection

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
                                                <h4>@lang('lang.images') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('image.update',$image) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_login')</label>
                                                            <input type="file" class="form-control" name="image_login" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_login)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_register')</label>
                                                            <input type="file" class="form-control" name="image_register" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_register)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_join_us')</label>
                                                            <input type="file" class="form-control" name="image_join_us" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_join_us)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_top_logo')</label>
                                                            <input type="file" class="form-control" name="image_top_logo" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_top_logo)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_footer_logo')</label>
                                                            <input type="file" class="form-control" name="image_footer_logo" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_footer_logo)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image_fav')</label>
                                                            <input type="file" class="form-control" name="image_fav" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($image->image_fav)}}" style="width: 100px; height: 100px;">
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

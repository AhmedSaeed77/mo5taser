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
                                                <h4>@lang('lang.product') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('subscribes.update',$subscribe) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.course')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.course')" required value="{{ $subscribe->course->title }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.user')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.user')" required value="{{ $subscribe->user->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.coupon')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.coupon')" required value="{{ $subscribe->coupon }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.difference')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.difference')" required value="{{ $subscribe->difference }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.account_holder_name')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.account_holder_name')" required value="{{ $subscribe->user_account_name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.bank_name')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            placeholder="@lang('lang.bank_name')" required value="{{ $subscribe->bank_name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.transfer_date')</label>
                                                            <input type="date" class="form-control" id="field-1"
                                                             required value="{{ $subscribe->transfer_date }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <br>
                                                            <a href="{{asset($subscribe->image)}}" target="_blank">
                                                                <img class="img-thumbnail" src="{{asset($subscribe->image)}}" style="width: 100px; height: 100px;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.total')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            required value="{{ $subscribe->total }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.start_subscribe')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            required value="{{ $subscribe->start_subscribe }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.end_subscribe')</label>
                                                            <input type="text" class="form-control" id="field-1"
                                                            required value="{{ $subscribe->end_subscribe }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">@lang('lang.activation')</label>
                                                        <select class="form-control" id="field-1" name="active">
                                                            <option value="0" {{$subscribe->active ==  0 ? 'selected' : ''}}>@lang('lang.not_active')</option>
                                                            <option value="1" {{$subscribe->active == 1 ? 'selected' : ''}}>@lang('lang.active')</option>
                                                        </select>
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

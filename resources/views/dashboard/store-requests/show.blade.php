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
                                                <h4>@lang('lang.store_requests') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->email }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->phone }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.city')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->city }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.area')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->area }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.street')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->street }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.price')</label>
                                                            <input type="text" class="form-control" value="{{ $payment->price }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.type')</label>
                                                            <input type="text" class="form-control" value="{{$payment->type == 'printed' ? __('lang.printed version') : __('lang.Pdf Version')}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.user')</label>
                                                            <input type="text" class="form-control" value="{{$payment->user->name ?? ''}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.book_name')</label>
                                                            <input type="text" class="form-control" value="{{$payment->assemble->title ?? ""}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

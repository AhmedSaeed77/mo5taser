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
                                                <h4>@lang('lang.exchanges') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('exchange.update',$exchange) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                                    <input type="text" class="form-control" id="field-1"name="name"
                                                                    placeholder="@lang('lang.name')" required value="{{$exchange->user->name }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="email"
                                                                    placeholder="@lang('lang.email')" required value="{{$exchange->user->email }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="phone"
                                                                    placeholder="@lang('lang.phone')" required value="{{$exchange->user->phone }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.balance')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="balance"
                                                                    placeholder="@lang('lang.all balance')" required value="{{$exchange->user->balance }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.amount')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="amount"
                                                                    placeholder="@lang('lang.amount')" required value="{{$exchange->amount }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.status')</label>
                                                                    <select class="form-control" name="status" required>
                                                                        <option value="un_read" {{$exchange->status == 'un_read' ? 'selected' : ''}}>@lang('lang.un_read')</option>
                                                                        <option value="read" {{$exchange->status == 'read' ? 'selected' : ''}}>@lang('lang.read')</option>
                                                                        <option value="delivered" {{$exchange->status == 'delivered' ? 'selected' : ''}}>@lang('lang.delivered')</option>
                                                                        <option value="refused" {{$exchange->status == 'refused' ? 'selected' : ''}}>@lang('lang.refused')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.paid_or_not')</label>
                                                                    <select class="form-control" name="paid" required {{$exchange->paid == 1 ? 'disabled' : ''}}>
                                                                        <option value="1" {{$exchange->paid == 1 ? 'selected' : ''}}>@lang('lang.paid')</option>
                                                                        <option value="0" {{$exchange->paid == 0 ? 'selected' : ''}}>@lang('lang.unpaid')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image_transfer" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            @if($exchange->image_transfer)
                                                                <br>
                                                                <a href="{{asset($exchange->image_transfer)}}" target="_blank">
                                                                    <img class="img-thumbnail" src="{{asset($exchange->image_transfer)}}" style="width: 100px; height: 100px;">
                                                                </a>
                                                            @endif
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

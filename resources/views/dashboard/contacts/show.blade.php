@extends('dashboard.includes.app')
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
                                                <h4>@lang('lang.contact_us') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                                    <input type="text" class="form-control" id="field-1"name="name"
                                                                    placeholder="@lang('lang.name')" required value="{{$contact->name }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="email"
                                                                    placeholder="@lang('lang.email')" required value="{{$contact->email }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="phone"
                                                                    placeholder="@lang('lang.phone')" required value="{{$contact->phone }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.msg')</label>
                                                            <textarea class="form-control autogrow" id="field-7" name="msg"
                                                            placeholder="@lang('lang.msg')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;" readonly>{{ $contact->msg }}</textarea>
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

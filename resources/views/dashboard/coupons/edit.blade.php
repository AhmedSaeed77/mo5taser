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
                                                <h4>@lang('lang.coupons') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('coupon.update',$coupon) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.coupon')</label>
                                                            <input type="text" class="form-control" id="field-1" name="coupon"
                                                            placeholder="@lang('lang.coupon')" required value="{{ $coupon->coupon }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.course')</label>
                                                            <select class="form-control" id="field-1" name="course_id">
                                                                @if($courses->count() > 0)
                                                                    @foreach ($courses as $course)
                                                                        <option value="{{$course->id}}" {{$coupon->course_id == $course->id ? 'selected' : ''}}>{{$course->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.user')</label>
                                                            <select class="form-control" id="field-1" name="user_id">
                                                                <option value="">@lang('lang.without_user')</option>
                                                                @if($users->count() > 0)
                                                                    @foreach ($users as $user)
                                                                        <option value="{{$user->id}}" {{$coupon->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.type')</label>
                                                            <select class="form-control" id="field-1" name="type">
                                                                <option value="paid" {{$coupon->type == 'paid' ? 'selected' : ''}}>@lang('lang.paid')</option>
                                                                {{--  <option value="free" {{$coupon->type == 'free' ? 'selected' : ''}}>@lang('lang.free')</option>  --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.discount') % (<span style="color: red">@lang('lang.optional'))</label>
                                                            <input type="number" min="1"  max="99" class="form-control" id="field-1" name="discount"
                                                            placeholder="@lang('lang.discount')"  value="{{ $coupon->discount }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.discount_number') (<span style="color: red">@lang('lang.optional'))</label>
                                                            <input type="number" min="1" class="form-control" id="field-1" name="discount_number"
                                                            placeholder="@lang('lang.discount_number')" value="{{ $coupon->discount_number }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.use_number')</label>
                                                            <input type="number" min="1" class="form-control" id="field-1" name="use_number"
                                                            placeholder="@lang('lang.use_number')" required value="{{ $coupon->use_number }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="coupon_id" value="{{$coupon->id}}">
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

@extends('dashboard.includes.app')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css"
     integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .pac-container.pac-logo.hdpi {
        z-index: 9999999999;
    }
    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100%;
    }

    .iti.iti--allow-dropdown.iti--separate-dial-code input {
        width: 100%;
    }

    .iti__country-list {
        left: 0;
        right: auto;
    }

    </style>
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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.infos')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.email')</th>
                                            <th class="text-center">@lang('lang.address')</th>
                                            <th class="text-center">@lang('lang.phone')</th>
                                            <th class="text-center">@lang('lang.whatsapp')</th>
                                            <th class="text-center">@lang('lang.twitter')</th>
                                            <th class="text-center">@lang('lang.min_profit')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($infos->count() > 0)
                                                @foreach ($infos as $key => $info)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{$info->email}}</td>
                                                        <td class="text-center">{{ $info->{'address_'.app()->getLocale()} }}</td>
                                                        <td class="text-center">{{$info->phone}}</td>
                                                        <td class="text-center">{{$info->whatsapp}}</td>
                                                        <td class="text-center">{{$info->twitter}}</td>
                                                        <td class="text-center">{{$info->min_profit}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('info.edit' ,$info->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            data-id="{{$info->id}}"> @lang('lang.delete') </button>

                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('info.destroy',$info->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                <form action="{{ route('info.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.email')</label>
                                    <input type="email" class="form-control" name="email"
                                    placeholder="@lang('lang.email')" required value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.address')</label>
                                    <input type="text" class="form-control" id="search_map" name="address"
                                    placeholder="@lang('lang.address')" required value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                    <input type="text" class="form-control" name="phone"
                                    placeholder="@lang('lang.phone')" required value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.whatsapp')</label>
                                    <input type="number" class="form-control" name="whatsapp" id="phone_num"
                                    placeholder="@lang('lang.whatsapp')" required value="{{ old('whatsapp') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.facebook')</label>
                                    <input type="url" class="form-control" name="facebook"
                                    placeholder="@lang('lang.facebook')" required value="{{ old('facebook') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.instagram')</label>
                                    <input type="url" class="form-control" name="instagram"
                                    placeholder="@lang('lang.instagram')" required value="{{ old('instagram') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.twitter')</label>
                                    <input type="url" class="form-control" name="twitter"
                                    placeholder="@lang('lang.twitter')" required value="{{ old('twitter') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.preview_video')</label>
                                    <input type="url" class="form-control" name="video"
                                    placeholder="@lang('lang.preview_video')" required value="{{ old('video') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.tax_number')</label>
                                    <input type="number" class="form-control" name="tax_number"
                                    placeholder="@lang('lang.tax_number')" required value="{{ old('tax_number') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.tax') (<span style="color:red">@lang('lang.optional')</span>)</label>
                                    <input type="number" class="form-control" name="tax" min="1" max="99"
                                    placeholder="@lang('lang.tax')" value="{{ old('tax') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.min_profit')</label>
                                    <input type="number" min="1" class="form-control" name="min_profit"
                                    placeholder="@lang('lang.min_profit')" required value="{{ old('min_profit') }}">
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
    {{--  modal  --}}

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    @include('dashboard.includes.map')
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
        var phone_number = window.intlTelInput(document.querySelector("#phone_num"), {
                separateDialCode: true,
                preferredCountries:["sa"],
                hiddenInput: "full",
                utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
            });
            $("form").submit(function() {
                var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
                $("input[name='phone[full]']").val(full_number);
        });
    </script>

@endsection


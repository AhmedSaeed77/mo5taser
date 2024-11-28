@extends('dashboard.includes.app')
@section('css')
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css"
     integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                                <h4>@lang('lang.infos_edit') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('info.update',$info) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group p-2">
                                                            <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                            <input type="email" class="form-control" name="email"
                                                            placeholder="@lang('lang.email')" required value="{{ $info->email }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group p-2">
                                                            <label for="field-1" class="control-label">@lang('lang.address')</label><br>
                                                            <input type="text" class="form-control w-50" id="search_map" name="address_ar"
                                                            placeholder="@lang('lang.arabic')" required value="{{ $info->address_ar }}" style="
    width: 50%;
    display: inline-block;
">
                                                            <input type="text" class="form-control w-50" id="search_map" name="address_en"
                                                            placeholder="@lang('lang.english')" required value="{{ $info->address_en }}" style="
    width: 49%;
    display: inline-block;
">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                            <input type="text" class="form-control" name="phone"
                                                            placeholder="@lang('lang.phone')" required value="{{ $info->phone }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.whatsapp')</label>
                                                            <input type="number" class="form-control" name="whatsapp" id="phone_num"
                                                            placeholder="@lang('lang.whatsapp')" required value="{{ $info->whatsapp }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.facebook')</label>
                                                            <input type="url" class="form-control" name="facebook"
                                                            placeholder="@lang('lang.facebook')" required value="{{ $info->facebook }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.instagram')</label>
                                                            <input type="url" class="form-control" name="instagram"
                                                            placeholder="@lang('lang.instagram')" required value="{{ $info->instagram }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.twitter')</label>
                                                            <input type="url" class="form-control" name="twitter"
                                                            placeholder="@lang('lang.twitter')" required value="{{ $info->twitter }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label >@lang('lang.preview video platform')</label>
                                                            <select class="form-control" name="video_platform">
                                                                <option {{ $info->video_platform == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                                                <option {{ $info->video_platform == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.preview_video')</label>
                                                            <input type="url" class="form-control" name="video"
                                                            placeholder="@lang('lang.preview_video')" required value="{{ $info->video }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.tax_number')</label>
                                                            <input type="number" class="form-control" name="tax_number"
                                                            placeholder="@lang('lang.tax_number')" required value="{{ $info->tax_number }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.tax')</label>
                                                            <input type="number" min="1" max="99" class="form-control" name="tax"
                                                            placeholder="@lang('lang.tax')" value="{{ $info->tax }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.min_profit')</label>
                                                            <input type="number" min="1" class="form-control" name="min_profit"
                                                            placeholder="@lang('lang.min_profit')" required value="{{ $info->min_profit }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    @include('dashboard.includes.map')
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

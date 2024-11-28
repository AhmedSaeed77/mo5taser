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

        .d-none {
            display: none
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
                                                <h4>@lang('lang.admins_edit') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('admin.update.user',$admin) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                            <input type="text" class="form-control" name="name"
                                                            placeholder="@lang('lang.name')" required value="{{$admin->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                            <input type="email" class="form-control" name="email"
                                                            placeholder="@lang('lang.email')" required value="{{$admin->email}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                            <input type="number" class="form-control" name="phone"
                                                            placeholder="@lang('lang.phone')" required  value="{{$admin->phone}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.password')</label>
                                                            <input type="password" class="form-control" name="password"
                                                            placeholder="@lang('lang.password')" >
                                                            <span style="color:red">@lang('lang.optional')</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color:red">@lang('lang.optional')</span>
                                                            <br>
                                                            @if ($admin->image)
                                                                <img class="img-thumbnail" src="{{asset($admin->image)}}" style="width: 100px; height: 100px; border-radius: 50%">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="admin" value="{{$admin->id}}">
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

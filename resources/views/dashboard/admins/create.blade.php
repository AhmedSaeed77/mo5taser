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
                                                <h4>@lang('lang.admin_create') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('admins.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                            <input type="text" class="form-control" name="name"
                                                            placeholder="@lang('lang.name')" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                            <input type="email" class="form-control" name="email"
                                                            placeholder="@lang('lang.email')" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                            <input type="number" class="form-control"  name="phone"
                                                            placeholder="@lang('lang.phone')" required >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.password')</label>
                                                            <input type="password" class="form-control" name="password"
                                                            placeholder="@lang('lang.password')" required >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color:red">@lang('lang.optional')</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.activation')</label>
                                                            <select class="form-control" name="active" required>
                                                                <option value="1">@lang('lang.active')</option>
                                                                <option value="0">@lang('lang.un_active')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.role')</label>
                                                            <select class="form-control" name="role" id="role" required>
                                                                @if($roles->count() > 0)
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row role_level">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.subjects')</label>
                                                            <select class="form-control" name="subject" id="subject" required>
                                                                @if($subjects->count() > 0)
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    @foreach ($subjects as $subject)
                                                                        <option value="{{$subject->name}}">{{$subject->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer pull-right">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
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
        <script>
            $(document).ready(function(){


                $('#role').on('change',function(){
                    var role = $(this).val();
                    if(role == 3)
                    {
                        $('.role_level').removeClass('d-none')
                        $('#subject').attr('required', true);
                    }
                    if(role == 2)
                    {
                        $('.role_level').addClass('d-none')
                        $('#subject').attr('required', false);
                    }
                });
            });
        </script>
@endsection

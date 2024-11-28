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
                                                <h4>@lang('lang.users_edit') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('users.update',$user) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="terms" value="on">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.name')</label>
                                                            <input type="text" class="form-control" name="name"
                                                            placeholder="@lang('lang.name')" required value="{{$user->name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.email')</label>
                                                            <input type="email" class="form-control" name="email"
                                                            placeholder="@lang('lang.email')" required value="{{$user->email}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.phone')</label>
                                                            <input type="number" class="form-control" name="phone"
                                                            placeholder="@lang('lang.phone')" required  value="{{$user->phone}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.password')</label>
                                                            <div class="pass-group">
                                                                <input type="password" class="form-control" name="password"
                                                            placeholder="@lang('lang.password')" id="password-field" >
                                                                <span toggle="#password-field" class="fa toggle-password fa-eye"></span>
                                                            </div>

                                                            <span style="color:red">@lang('lang.optional')</span>
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
                                                                        <option value="{{$role->id}}" {{$role->id == $user->role_id ? 'selected' : ''}}>{{$role->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
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
                                                            @if ($user->image)
                                                                <img class="img-thumbnail" src="{{asset($user->image)}}" style="width: 100px; height: 100px; border-radius: 50%">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.activation')</label>
                                                            <select class="form-control" name="active" required>
                                                                <option value="1" {{$user->active == 1 ? 'selected' : ''}}>@lang('lang.active')</option>
                                                                <option value="0" {{$user->active == 0 ? 'selected' : ''}}>@lang('lang.un_active')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row role_level {{$user->type == 'teacher' ? 'd-none' : ''}}">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.educational_level')</label>
                                                            <select class="form-control" name="educational_level" id="educational_level">
                                                                <option value="">@lang('lang.choose')</option>
                                                                <option value="University stage" {{$user->educational_level === 'University stage' ? 'selected' : ''}}>@lang('lang.University stage')</option>
                                                                <option value="High school" {{$user->educational_level === 'High school' ? 'selected' : ''}}>@lang('lang.High school')</option>
                                                                <option value="Secondary school" {{$user->educational_level === 'Secondary school' ? 'selected' : ''}}>@lang('lang.Secondary school')</option>
                                                                <option value="Primary school" {{$user->educational_level === 'Primary school' ? 'selected' : ''}}>@lang('lang.Primary school')</option>
                                                                <option value="Kindergarten" {{$user->educational_level === 'Kindergarten' ? 'selected' : ''}}>@lang('lang.Kindergarten')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row role_level {{$user->type == 'teacher' ? 'd-none' : ''}}">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.level')</label>
                                                            <select class="form-control" name="level" id="level" >
                                                            </select>
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
                var educational_level = $('#educational_level').val();

                    if(educational_level === 'University stage')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="Student" {{$user->level == 'Student' ? 'selected' : ''}}>@lang('lang.Student')</option>
                            <option value="Graduated" {{$user->level == 'Graduated' ? 'selected' : ''}}>@lang('lang.Graduated')</option>
                        `);
                    }
                    if(educational_level === 'High school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First High school" {{$user->level == 'First High school' ? 'selected' : ''}}>@lang('lang.First High school')</option>
                            <option value="Second High school" {{$user->level == 'Second High school' ? 'selected' : ''}}>@lang('lang.Second High school')</option>
                            <option value="Third High school" {{$user->level == 'Third High school' ? 'selected' : ''}}>@lang('lang.Third High school')</option>
                            <option value="High school graduate" {{$user->level == 'High school graduate' ? 'selected' : ''}}>@lang('lang.High school graduate')</option>
                        `);
                    }
                    if(educational_level === 'Secondary school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                        <option value="">@lang('lang.choose')</option>
                        <option value="First Secondary school" {{$user->level == 'First Secondary school' ? 'selected' : ''}}>@lang('lang.First Secondary school')</option>
                        <option value="Second Secondary school" {{$user->level == 'Second Secondary school' ? 'selected' : ''}}>@lang('lang.Second Secondary school')</option>
                        <option value="Third Secondary school" {{$user->level == 'Third Secondary school' ? 'selected' : ''}}>@lang('lang.Third Secondary school')</option>
                        `);
                    }
                    if(educational_level === 'Primary school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First Primary school" {{$user->level == 'First Primary school' ? 'selected' : ''}}>@lang('lang.First Primary school')</option>
                            <option value="Second Primary school" {{$user->level == 'Second Primary school' ? 'selected' : ''}}>@lang('lang.Second Primary school')</option>
                            <option value="Third Primary school" {{$user->level == 'Third Primary school' ? 'selected' : ''}}>@lang('lang.Third Primary school')</option>
                            <option value="Fourth Primary school" {{$user->level == 'Fourth Primary school' ? 'selected' : ''}}>@lang('lang.Fourth Primary school')</option>
                            <option value="Fifth Primary school" {{$user->level == 'Fifth Primary school' ? 'selected' : ''}}>@lang('lang.Fifth Primary school')</option>
                            <option value="The Sixth Primary school" {{$user->level == 'The Sixth Primary school' ? 'selected' : ''}}>@lang('lang.The Sixth Primary school')</option>
                        `);
                    }
                    if(educational_level === 'Kindergarten')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First Kindergarten" {{$user->level == 'First Kindergarten' ? 'selected' : ''}}>@lang('lang.First Kindergarten')</option>
                            <option value="Second Kindergarten" {{$user->level == 'Second Kindergarten' ? 'selected' : ''}}>@lang('lang.Second Kindergarten')</option>
                            <option value="Third Kindergarten" {{$user->level == 'Third Kindergarten' ? 'selected' : ''}}>@lang('lang.Third Kindergarten')</option>
                        `);
                    }


                $('#educational_level').on('change',function(){
                    var val = $(this).val();
                    if(val === 'University stage')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="Student" {{$user->level == 'Student' ? 'selected' : ''}}>@lang('lang.Student')</option>
                            <option value="Graduated" {{$user->level == 'Graduated' ? 'selected' : ''}}>@lang('lang.Graduated')</option>
                        `);
                    }
                    if(val === 'High school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First High school" {{$user->level == 'First High school' ? 'selected' : ''}}>@lang('lang.First High school')</option>
                            <option value="Second High school" {{$user->level == 'Second High school' ? 'selected' : ''}}>@lang('lang.Second High school')</option>
                            <option value="Third High school" {{$user->level == 'Third High school' ? 'selected' : ''}}>@lang('lang.Third High school')</option>
                            <option value="High school graduate" {{$user->level == 'High school graduate' ? 'selected' : ''}}>@lang('lang.High school graduate')</option>
                        `);
                    }
                    if(val === 'Secondary school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                        <option value="">@lang('lang.choose')</option>
                        <option value="First Secondary school" {{$user->level == 'First Secondary school' ? 'selected' : ''}}>@lang('lang.First Secondary school')</option>
                        <option value="Second Secondary school" {{$user->level == 'Second Secondary school' ? 'selected' : ''}}>@lang('lang.Second Secondary school')</option>
                        <option value="Third Secondary school" {{$user->level == 'Third Secondary school' ? 'selected' : ''}}>@lang('lang.Third Secondary school')</option>
                        `);
                    }
                    if(val === 'Primary school')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First Primary school" {{$user->level == 'First Primary school' ? 'selected' : ''}}>@lang('lang.First Primary school')</option>
                            <option value="Second Primary school" {{$user->level == 'Second Primary school' ? 'selected' : ''}}>@lang('lang.Second Primary school')</option>
                            <option value="Third Primary school" {{$user->level == 'Third Primary school' ? 'selected' : ''}}>@lang('lang.Third Primary school')</option>
                            <option value="Fourth Primary school" {{$user->level == 'Fourth Primary school' ? 'selected' : ''}}>@lang('lang.Fourth Primary school')</option>
                            <option value="Fifth Primary school" {{$user->level == 'Fifth Primary school' ? 'selected' : ''}}>@lang('lang.Fifth Primary school')</option>
                            <option value="The Sixth Primary school" {{$user->level == 'The Sixth Primary school' ? 'selected' : ''}}>@lang('lang.The Sixth Primary school')</option>
                        `);
                    }
                    if(val === 'Kindergarten')
                    {
                        $("#level").empty();
                        $("#level").append(`
                            <option value="">@lang('lang.choose')</option>
                            <option value="First Kindergarten" {{$user->level == 'First Kindergarten' ? 'selected' : ''}}>@lang('lang.First Kindergarten')</option>
                            <option value="Second Kindergarten" {{$user->level == 'Second Kindergarten' ? 'selected' : ''}}>@lang('lang.Second Kindergarten')</option>
                            <option value="Third Kindergarten" {{$user->level == 'Third Kindergarten' ? 'selected' : ''}}>@lang('lang.Third Kindergarten')</option>
                        `);
                    }
                });

                $('#role').on('change',function(){
                    var role = $(this).val();
                    if(role == 4)
                    {
                        $('.role_level').removeClass('d-none')
                        $('#educational_level').attr('required', true);
                        $('#level').attr('required', true);
                    }
                    if(role == 5)
                    {
                        $('.role_level').addClass('d-none')
                        $('#educational_level').attr('required', false);
                        $('#level').attr('required', false);
                    }
                });
            });
        </script>
@endsection

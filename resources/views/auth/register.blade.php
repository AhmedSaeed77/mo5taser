@extends('site.includes.master')

@section('content')
<!--========================== Start register page =============================-->
<section class="login_page register_page">
    <div class="container">
        <h4 class="head_page mb-40 main-color text-center">@lang('lang.create_account')</h4>
        <div class="form_modal wow animate__animated animate__fadeInUp">
            <div class="row no-gutters">
                <div class="col-lg-6 o-2">

                    <!-- <div class="input_form">
                        <span class="icon"><i class="la la-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="example@mail.com">
                    </div> -->

                    <div class="form-wizard">
                        <form action="{{ route('register') }}" method="post" role="form" class="form-m">
                            @csrf
                            <div class="form-wizard-header">
                                <ul class="list-unstyled form-wizard-steps clearfix" id="progressbar">
                                    <li class="active"></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                            <div class="form-content">
                                <fieldset class="wizard-fieldset show">
                                    <div class="content_fieldset">
                                        <h5 class="head mb-30">@lang('lang.personal_infos')</h5>
                                        <div class="form-group">
                                            <label for="">@lang('lang.name')</label>
                                            <div class="input_form">
                                                <span class="icon"><i class="la la-user"></i></span>
                                                <input type="text" name="name" class="form-control wizard-required" placeholder="@lang('lang.name')" value="{{old('name')}}">
                                                <div class="wizard-form-error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">@lang('lang.email')</label>
                                            <div class="input_form">
                                                <span class="icon"><i class="la la-envelope"></i></span>
                                                <input type="email" name="email" class="form-control wizard-required" placeholder="example@gmail.com" value="{{old('email')}}">
                                                <div class="wizard-form-error"></div>
                                                <div class="messag-error">@lang('lang.enter_valid_email')</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">@lang('lang.phone') (@lang('lang.starts with 966'))</label>
                                            <div class="input_form">
                                                <span class="icon"><i class="las la-phone-volume"></i></span>
                                                <input type="tel" name="phone" class="form-control wizard-required" style="direction: ltr !important;" placeholder="966XXXXXXXXXX" pattern="/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/" value="{{old('phone')}}">
                                                <div class="wizard-form-error"></div>
                                                <div class="messag-error">@lang('lang.starts with 966')</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" class="form-wizard-next-btn main-btn main mt-10">@lang('lang.next')</a>
                                    </div>
                                </fieldset>
                                <fieldset class="wizard-fieldset ">
                                    <div class="content_fieldset">
                                        <div class="block">
                                            <h5 class="head mb-30"> @lang('lang.teacher_or_student') </h5>
                                            <div class="radio_div  flex-center-h">
                                                <label for="ch3" class="custom_checkbox m-0">
                                                    <input type="radio" class="d-none" id="ch3" name="type" value="student" checked>
                                                    <span class="checkmark"></span>
                                                    <p>@lang('lang.student')</p>
                                                </label>
                                                <label for="ch4" class="custom_checkbox m-0">
                                                    <input type="radio" class="d-none" id="ch4" name="type" value="teacher">
                                                    <span class="checkmark"></span>
                                                    <p>@lang('lang.teacher')</p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="block_content">
                                            <div id="firstContent">
                                                <div class="radio_div_2 flex-between flex-center-h">
                                                    <label for="st_1" class="custom_checkbox m-0">
                                                        <input type="radio" class="d-none educational_level" id="st_1" name="educational_level" value="University stage" checked>
                                                        <span class="checkmark"></span>
                                                        <p>@lang('lang.University stage')</p>
                                                    </label>
                                                    <label for="st_2" class="custom_checkbox m-0">
                                                        <input type="radio" class="d-none educational_level" id="st_2" name="educational_level" value="High school">
                                                        <span class="checkmark"></span>
                                                        <p>@lang('lang.High school')</p>
                                                    </label>
                                                    <label for="st_3" class="custom_checkbox m-0">
                                                        <input type="radio" class="d-none educational_level" id="st_3" name="educational_level" value="Secondary school">
                                                        <span class="checkmark"></span>
                                                        <p>@lang('lang.Secondary school')</p>
                                                    </label>
                                                    <label for="st_4" class="custom_checkbox m-0">
                                                        <input type="radio" class="d-none educational_level" id="st_4" name="educational_level" value="Primary school">
                                                        <span class="checkmark"></span>
                                                        <p>@lang('lang.Primary school')</p>
                                                    </label>
                                                    <label for="st_5" class="custom_checkbox m-0">
                                                        <input type="radio" class="d-none educational_level" id="st_5" name="educational_level" value="Kindergarten">
                                                        <span class="checkmark"></span>
                                                        <p>@lang('lang.Kindergarten')</p>
                                                    </label>
                                                </div>
                                                <div class="all_tabs mt-30">
                                                    <div id="student_1">
                                                        <div class="form-group">
                                                            <label for="">@lang('lang.University stage')</label>
                                                            <div class="input_form">
                                                                <select required class="form-control level">
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    <option value="Student">@lang('lang.Student')</option>
                                                                    <option value="Graduated">@lang('lang.Graduated')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="student_2">
                                                        <div class="form-group">
                                                            <label for="">@lang('lang.High school')</label>
                                                            <div class="input_form">
                                                                <select required class="form-control level">
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    <option value="First High school">@lang('lang.First High school')</option>
                                                                    <option value="Second High school">@lang('lang.Second High school')</option>
                                                                    <option value="Third High school">@lang('lang.Third High school')</option>
                                                                    <option value="High school graduate">@lang('lang.High school graduate')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="student_3">
                                                        <div class="form-group">
                                                            <label for="">@lang('lang.Secondary school')</label>
                                                            <div class="input_form">
                                                                <select required class="form-control level">
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    <option value="First Secondary school">@lang('lang.First Secondary school')</option>
                                                                    <option value="Second Secondary school">@lang('lang.Second Secondary school')</option>
                                                                    <option value="Third Secondary school">@lang('lang.Third Secondary school')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="student_4">
                                                        <div class="form-group">
                                                            <label for="">@lang('lang.Primary school')</label>
                                                            <div class="input_form">
                                                                <select required class="form-control level">
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    <option value="First Primary school">@lang('lang.First Primary school')</option>
                                                                    <option value="Second Primary school">@lang('lang.Second Primary school')</option>
                                                                    <option value="Third Primary school">@lang('lang.Third Primary school')</option>
                                                                    <option value="Fourth Primary school">@lang('lang.Fourth Primary school')</option>
                                                                    <option value="Fifth Primary school">@lang('lang.Fifth Primary school')</option>
                                                                    <option value="The Sixth Primary school">@lang('lang.The Sixth Primary school')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="student_5">
                                                        <div class="form-group">
                                                            <label for="">@lang('lang.Kindergarten')</label>
                                                            <div class="input_form">
                                                                <select required class="form-control level">
                                                                    <option value="">@lang('lang.choose')</option>
                                                                    <option value="First Kindergarten">@lang('lang.First Kindergarten')</option>
                                                                    <option value="Second Kindergarten">@lang('lang.Second Kindergarten')</option>
                                                                    <option value="Third Kindergarten">@lang('lang.Third Kindergarten')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="level" name="level" value="">
                                                </div>
                                            </div>
                                            <div id="secondContent" style="display: none;">
                                                <div class="form-group">
                                                    <label for="">@lang('lang.specs')</label>
                                                    @php
                                                        $specs = \App\Models\Spec::get();
                                                    @endphp
                                                    <div class="input_form">
                                                        <select required class="form-control" name="spec">
                                                            <option value="">@lang('lang.choose')</option>
                                                            @if($specs->count() > 0)
                                                                @foreach ($specs as $spec)
                                                                    <option value="{{$spec->title}}">{{$spec->title}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group control_btns  flex-center-h flex-between mt-30">
                                        <a href="javascript:;" class="form-wizard-previous-btn main-btn back">
                                            <i class="las la-arrow-right"></i>
                                            <span></span>
                                        </a>
                                        <a href="javascript:;" class="form-wizard-next-btn main-btn main">@lang('lang.next')</a>
                                    </div>
                                </fieldset>
                                <fieldset class="wizard-fieldset">
                                    <div class="content_fieldset">
                                        <h5 class="head mb-30">@lang('lang.create_password')</h5>
                                        <div class="form-group">
                                            <label for="">@lang('lang.password')</label>
                                            <div class="input_form">
                                                <span class="icon"><i class="la la-lock"></i></span>
                                                <input type="password" class="form-control wizard-required" name="password" minlength="8" placeholder="@lang('lang.password')" id="password-field">
                                                <span toggle="#password-field" class="fa toggle-password fa-eye"></span>
                                                <div class="wizard-form-error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">@lang('lang.confirm_password')</label>
                                            <div class="input_form">
                                                <span class="icon"><i class="la la-lock"></i></span>
                                                <input type="password" class="form-control wizard-required" name="password_confirmation" minlength="8" placeholder="@lang('lang.confirm_password')" id="password-field_2">
                                                <span toggle="#password-field_2" class="fa toggle-password fa-eye"></span>
                                                <div class="wizard-form-error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="agree" class="m-0">
                                                <input name="terms" type="checkbox" id="agree">
                                                <span class="agree_text">@lang('lang.agree_on') <a href="{{route('term')}}" target="_blank">@lang('lang.terms_condtion')</a></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group control_btns  flex-center-h flex-between mt-30">
                                        <a href="javascript:;" class="form-wizard-previous-btn main-btn back">
                                            <i class="las la-arrow-right"></i>
                                            <span></span>
                                        </a>
                                        <button type="submit" class="main-btn form-wizard-submit sec border-0">@lang('lang.register')</button>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image h-100">
                        <img src="{{asset($image_control->image_register ?? 'site/images/register.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== End register page =============================-->
@endsection
@section('js')
    <script>
        jQuery(document).ready(function() {
            // click on next button
            var email_input = $('.wizard-fieldset.show input[type="email"]');
            var phone_input = $('.wizard-fieldset.show input[type="tel"]');
            jQuery('.form-wizard-next-btn').click(function() {
                var parentFieldset = jQuery(this).parents('.wizard-fieldset');
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                var next = jQuery(this);
                var nextWizardStep = true;
                parentFieldset.find('.wizard-required').each(function() {
                    var thisValue = jQuery(this).val();

                    if (thisValue == "") {
                        jQuery(this).siblings(".wizard-form-error").slideDown();
                        nextWizardStep = false;
                    } else {
                        jQuery(this).siblings(".wizard-form-error").slideUp();
                    }
                });
                if (email_input) {
                    if (email_input.val().includes("@")) {
                        email_input.siblings(".messag-error").slideUp();
                    } else {
                        email_input.siblings(".messag-error").slideDown();
                        nextWizardStep = false;
                    }
                }
                if (phone_input) {
                    var phoneValue = phone_input.val().replace(/\D/g, '');

                    // Using the regular expression to validate the phone number format
                    if (/^(9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/.test(phoneValue)) {
                        console.log("Valid phone number format");
                        phone_input.siblings(".messag-error").slideUp();
                        phone_input.siblings(".wizard-form-error").slideUp();
                    } else {
                        console.log("Invalid phone number format");
                        phone_input.siblings(".messag-error").slideDown();
                        phone_input.siblings(".wizard-form-error").slideDown();
                        nextWizardStep = false;
                    }
                }

                if (nextWizardStep) {
                    next.parents('.wizard-fieldset').removeClass("show", "400");
                    currentActiveStep.removeClass('active').addClass('activated').next().addClass('active', "400");
                    next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show", "400");
                    jQuery(document).find('.wizard-fieldset').each(function() {
                        if (jQuery(this).hasClass('show')) {
                            var formAtrr = jQuery(this).attr('data-tab-content');
                            jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
                                if (jQuery(this).attr('data-attr') == formAtrr) {
                                    jQuery(this).addClass('active');
                                    var innerWidth = jQuery(this).innerWidth();
                                    var position = jQuery(this).position();
                                    jQuery(document).find('.form-wizard-step-move').css({
                                        "left": position.left,
                                        "width": innerWidth
                                    });
                                } else {
                                    jQuery(this).removeClass('active');
                                }
                            });
                        }
                    });
                }
            });
            //click on previous button
            jQuery('.form-wizard-previous-btn').click(function() {
                var counter = parseInt(jQuery(".wizard-counter").text());;
                var prev = jQuery(this);
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                prev.parents('.wizard-fieldset').removeClass("show", "400");
                prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show", "400");
                currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active', "400");
                jQuery(document).find('.wizard-fieldset').each(function() {
                    if (jQuery(this).hasClass('show')) {
                        var formAtrr = jQuery(this).attr('data-tab-content');
                        jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
                            if (jQuery(this).attr('data-attr') == formAtrr) {
                                jQuery(this).addClass('active');
                                var innerWidth = jQuery(this).innerWidth();
                                var position = jQuery(this).position();
                                jQuery(document).find('.form-wizard-step-move').css({
                                    "left": position.left,
                                    "width": innerWidth
                                });
                            } else {
                                jQuery(this).removeClass('active');
                            }
                        });
                    }
                });
            });
            //click on form submit button
            jQuery(document).on("click", ".form-wizard .form-wizard-submit", function() {
                var parentFieldset = jQuery(this).parents('.wizard-fieldset');
                var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
                parentFieldset.find('.wizard-required').each(function() {
                    var thisValue = jQuery(this).val();

                    if (thisValue == "") {
                        jQuery(this).siblings(".wizard-form-error").slideDown();
                    } else {
                        jQuery(this).siblings(".wizard-form-error").slideUp();
                        $('.form-m').submit();
                    }
                });


            });
            // focus on input field check empty or not
            jQuery(".form-control").on('focus', function() {
                var tmpThis = jQuery(this).val();
                if (tmpThis == '') {
                    jQuery(this).parent().addClass("focus-input");
                } else if (tmpThis != '') {
                    jQuery(this).parent().addClass("focus-input");
                }
            }).on('blur', function() {
                var tmpThis = jQuery(this).val();
                if (tmpThis == '') {
                    jQuery(this).parent().removeClass("focus-input");
                    jQuery(this).siblings('.wizard-form-error').slideDown("3000");
                } else if (tmpThis != '') {
                    jQuery(this).parent().addClass("focus-input");
                    jQuery(this).siblings('.wizard-form-error').slideUp("3000");
                }
            });
        });
    </script>
    <!-- Add this script at the end of your existing JavaScript code -->
    <script>
        jQuery(document).ready(function() {
            updateSubmitButtonStatus(); // Call the function initially

            // Function to update the submit button status
            function updateSubmitButtonStatus() {
                var submitButton = jQuery('.form-wizard .form-wizard-submit');
                var isFormValid = isFormValidated(); // Call a function to check overall form validation status

                // Enable or disable the button based on the validation status
                if (isFormValid) {
                    submitButton.removeClass('disabled').removeAttr('disabled');
                } else {
                    submitButton.addClass('disabled').attr('disabled', 'disabled');
                }
            }

            // Function to check overall form validation status
            function isFormValidated() {
                var isValid = true;

                jQuery('.form-wizard .wizard-required').each(function() {
                    var thisValue = jQuery(this).val();

                    if (thisValue == "") {
                        isValid = false;
                        return false; // Stop the loop if any required field is empty
                    }
                });

                var passwordField = jQuery('.form-wizard input[name="password"]');
                if (passwordField.val().length < 8) {
                    isValid = false;
                }

                return isValid;
            }

            // Call the function when any input field changes
            jQuery('.form-wizard .wizard-required').on('input', function() {
                updateSubmitButtonStatus();
            });

            // Real-time validation for the password field
            jQuery('.form-wizard input[name="password"]').on('keyup', function() {
                var passwordField = jQuery(this);
                var passwordLength = passwordField.val().length;

                if (passwordLength < 8) {
                    passwordField.siblings(".wizard-form-error").text("{{__('lang.password_error')}}").slideDown();
                } else {
                    passwordField.siblings(".wizard-form-error").slideUp();
                }

                updateSubmitButtonStatus(); // Update button status
            });

            // Click event for the form submit button
            jQuery('.form-wizard .form-wizard-submit').click(function() {
                var isFormValid = isFormValidated();

                if (!isFormValid) {
                    return false; // Prevent form submission if not valid
                }

                // Your existing submit logic
                $('.form-m').submit();
            });
        });
    </script>



    {{--  get level value  --}}
    <script>
        $(document).ready(function(){
            $('.educational_level').on('change',function(){
                $('select').val('')
                $("#level").val('');
            });
            $('.level').on('change',function(){
                console.log( $(this).val());
                $("#level").val($(this).val());
            });
        });
    </script>
    {{--  get level value  --}}

    <!-- Add this script at the end of your existing JavaScript code -->
    <script>

    </script>

@endsection

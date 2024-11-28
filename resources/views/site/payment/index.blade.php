@php use Carbon\Carbon; @endphp
@extends('site.includes.master')
@section('content')

    <div class="breadcrumbs wow animate__animated animate__fadeInUp">
        <div class="container">
            <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
            <span class="break">/</span>
            <span class="current">@lang('lang.payment')</span>
        </div>
    </div>
    <!--========================== Start payment page =============================-->
    <section class="payment_page">
        <div class="container">
            <div class="tabs-li">
                <ul>
                    <li class="mou_tab {{ request('method') !== 'bank' ? 'active' : '' }}" data-content="visa-method">
                        <img src="{{asset('site/images/visa.png')}}" alt="visa_logo">
                        <img src="{{asset('site/images/Mada_Logo.svg')}}" alt="mada_logo" class="mada_logo">
                    </li>
                    <li class="mou_tab {{ request('method') == 'bank' ? 'active' : '' }}" data-content="bank-method">@lang('lang.by_check')</li>


                </ul>
            </div>
            <div class="payment-body">
                <div class="box_content {{ request('method') !== 'bank' ? 'active' : '' }}" id="visa-method">
                    <div class="head">
                        <h5>@lang('lang.by_visa')</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{route('electronic_pay')}}" id="payment-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="info-visa">
                                            <div class="details">
                                                <div class="item" id="after_copoun_check">
                                                    <p>@lang('lang.total')</p>
                                                    <span class="price" >{{$total}} @lang('lang.rs')</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-5">
                                        <div class="info-bank">
                                            <div class="form-group">
                                                <label for="">@lang('lang.first_name')</label>
                                                <input type="text" class="form-control" name="first_name" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('lang.last_name')</label>
                                                <input type="text" class="form-control" name="last_name" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">@lang('lang.email')</label>
                                                <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}" required="">
                                            </div>
                                            <input type="hidden" name="type" value="electronic">

                                            {{--                                            <div class="col-12">--}}
                                            {{--                                                <div class="form-group m-0">--}}
                                            {{--                                                    <button type="submit" class="main-btn sec w-100">@lang('lang.confirm_pay')</button>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="form-container" method="post" action="{{route('electronic_pay')}}">
                                <div id="element-container"></div>
                                <div class="col-12">
                                    <div class="form-group m-0">
                                        <button type="submit" class="main-btn sec w-100">@lang('lang.confirm_pay')</button>
                                    </div>
                                </div>
                            </form>








                            {{--                            <form action="{{route('electronic_pay')}}" method="POST" enctype="multipart/form-data">--}}
                            {{--                                @csrf--}}
                            {{--                                @method('POST')--}}
                            {{--                                <input type="hidden" name="_method" value="POST">--}}
                            {{--                                <div class="row">--}}
                            {{--                                    <div class="col-lg-7">--}}
                            {{--                                        <div class="info-visa">--}}
                            {{--                                            <div class="details">--}}
                            {{--                                                <div class="item" id="after_copoun_check">--}}
                            {{--                                                    <p>@lang('lang.total')</p>--}}
                            {{--                                                    <span class="price" >{{$total}} @lang('lang.rs')</span>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}

                            {{--                                    </div>--}}
                            {{--                                    <div class="col-lg-5">--}}
                            {{--                                        <div class="info-bank">--}}
                            {{--                                            <div class="form-group">--}}
                            {{--                                                <label for="">@lang('lang.first_name')</label>--}}
                            {{--                                                <input type="text" class="form-control" name="first_name" required="">--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="form-group">--}}
                            {{--                                                <label for="">@lang('lang.last_name')</label>--}}
                            {{--                                                <input type="text" class="form-control" name="last_name" required="">--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="form-group">--}}
                            {{--                                                <label for="">@lang('lang.email')</label>--}}
                            {{--                                                <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}" required="">--}}
                            {{--                                            </div>--}}
                            {{--                                            <input type="hidden" name="type" value="electronic">--}}
                            {{--                                            <div class="col-12">--}}
                            {{--                                                <div class="form-group m-0">--}}
                            {{--                                                    <button type="submit" class="main-btn sec w-100">@lang('lang.Pay')</button>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </form>--}}
                        </div>

                    </div>
                </div>
                <div class="box_content {{ request('method') == 'bank' ? 'active' : '' }}" id="bank-method">
                    <div class="head">
                        <h5>@lang('lang.by_check')</h5>
                    </div>
                    <form action="{{route('payment.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="_method" value="POST">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="info-visa">
                                    @if ($banks->count() > 0)
                                        @foreach ($banks as $bank)
                                            <div class="details">
                                                <div class="item">
                                                    <p>@lang('lang.bank_name')</p>
                                                    <span>{{$bank->name}}</span>
                                                </div>
                                                <div class="item">
                                                    <p>@lang('lang.account_number')</p>
                                                    <span>{{$bank->account_number}}</span>
                                                </div>
                                                <div class="item">
                                                    <p>@lang('lang.iban_number')</p>
                                                    <span>{{$bank->iban}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="details">
                                        <div class="item" id="after_copoun_check">
                                            <p>@lang('lang.total')</p>
                                            <span class="price" >{{$total}} @lang('lang.rs')</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-5">
                                <div class="info-bank">
                                    <div class="form-group">
                                        <label for="">@lang('lang.account_holder_name')</label>
                                        <input type="text" class="form-control" name="user_account_name" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('lang.bank_name')</label>
                                        <input type="text" class="form-control" name="bank_name" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('lang.transfer_date') </label>
                                        <input type="datetime-local" class="form-control" name="transfer_date" value="{{ Carbon::now()}}" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">@lang('lang.image')</label>
                                        <input type="file" class="form-control" name="image" required="">
                                    </div>
                                    <input type="hidden" name="type" value="by_check">
                                    <div class="col-12">
                                        <div class="form-group m-0">
                                            <button type="submit" class="main-btn sec w-100">@lang('lang.confirm_pay')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </section>
    <!--========================== End payment page =============================-->

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
    <script>
        //pass your public key from tap's dashboard
        var tap = Tapjsli('{{env('TAP_PAYMENT_TEST_PK')}}');

        var elements = tap.elements({});

        var style = {
            base: {
                color: '#535353',
                lineHeight: '18px',
                fontFamily: 'sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: 'rgba(0, 0, 0, 0.26)',
                    fontSize:'15px'
                }
            },
            invalid: {
                color: 'red'
            }
        };
        // input labels/placeholders
        var labels = {
            cardNumber: "{{__("lang.Card Number")}}",
            expirationDate: "{{__("lang.MM/YY")}}",
            cvv: "{{__("lang.CVV")}}",
            cardHolder: "{{__("lang.Card Holder Name")}}"
        };
        //payment options
        var paymentOptions = {
            currencyCode:["KWD","USD","SAR"],
            labels : labels,
            TextDirection:'{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'
        }
        //create element, pass style and payment options
        var card = elements.create('card', {style: style},paymentOptions);
        //mount element
        card.mount('#element-container');
        //card change event listener
        card.addEventListener('change', function(event) {
            if(event.loaded){
                console.log("UI loaded :"+event.loaded);
                console.log("current currency is :"+card.getCurrency())
            }
            var displayError = document.getElementById('error-handler');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        var form = document.getElementById('form-container');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            tap.createToken(card).then(function(result) {
                console.log(result.id);
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('error-handler');
                    // errorElement.textContent = result.error.message;
                    toastr.error('{{ __('lang.Wrong payment details') }}')
                } else {
                    // Send the token to your server
                    // var errorElement = document.getElementById('success');
                    // errorElement.style.display = "block";
                    // var tokenElement = document.getElementById('token');
                    // tokenElement.textContent = result.id;
                    tapTokenHandler(result.id)

                }
            });
        });

        function tapTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_token');
            hiddenInput.setAttribute('value', token);
            form.appendChild(hiddenInput);


            // Submit the form
            form.submit();
        }

        card.addEventListener('change', function(event) {
            if(event.BIN){
                console.log(event.BIN)
            }
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    </script>
@endsection

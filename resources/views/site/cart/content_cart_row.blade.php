<h4 class="head_page main-color">@lang('lang.shopping_cart')</h4>
@php
$carts = \App\Models\Cart::where('user_id', auth()->id())->get();
@endphp
@if ($carts->count() > 0)
    <div class="row" >
        <div class="col-lg-8">
            <div class="my_products">
                @foreach ($carts as $item)
                <div class="cart_product">
                    <div class="flex-center-h flex-between">
                        <div class="info_broduct flex-center-h">
                            <a href="#" class="image d-block"><img src="{{asset($item->course->image)}}" alt=""></a>
                            <div class="details">
                                <h6 class="name"><a href="{{route('course.show',$item->course_id)}}">{{$item->course->title}}</a></h6>
                                <div class="meta">
                                    <div class="item flex-center-h">
                                        <i class="las la-clock"></i>
                                        <span class="text">{{$item->course->peroid}} (@lang('lang.day'))</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="more_details">
                            <div class="price sec-color">
                                <span class="num bold">{{$item->price}}</span>
                                <span class="text">@lang('lang.rs')</span>
                            </div>
                            <a href="{{route('removeFromCart',$item->id)}}">
                                <button type="button" class="main-btn trans">
                                    <i class="las la-trash"></i>
                                    <span>@lang('lang.delete')</span>
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="copon_box">
                        <p class="text">@lang('lang.do_you_have_code')</p>
                        <div class="input flex-center-h">
                            <input type="text" class="coupon_val"  value="{{$item->coupon}}" placeholder="@lang('lang.enter_coupon_here')" >
                            <button type="button" onclick="onClick(this)" data-id="{{$item->id}}" class="main-btn main btn_coupon">@lang('lang.activate_code')</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="cart_cardSide">
                <div class="head flex-center-h mb-30">
                    <span class="text">@lang('lang.total') :</span>
                    <span class="num">{{array_sum($carts->pluck('price')->toArray())}} @lang('lang.rs')</span>
                </div>
                <a href="{{route('payment.index')}}" class="main-btn sec w-100">@lang('lang.cart_checkout')</a>
            </div>
        </div>
    </div>
    <div class="text-center mt-50">
        <a href="{{route('delete.cart')}}" class="main-btn sec remove_all">@lang('lang.delete_cart')</a>
    </div>
@else
    <div class="row">
        <div class="alert alert-danger text-center">
            <b>@lang('lang.cart_empty')</b>
        </div>
    </div>
@endif

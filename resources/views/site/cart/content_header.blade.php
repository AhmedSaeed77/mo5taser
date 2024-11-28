@php
$carts = \App\Models\Cart::get();
@endphp
<span href="#" class="icon icon_cart">
    <i class="la la-shopping-cart"></i>
    <span class="active">{{$carts->count() > 0 ? $carts->count() : ''}}</span>
</span>
@if ($carts->count() > 0)
<div class="minicartBox">
    <h5>@lang('lang.courses_numbers')<strong> {{$carts->count() > 0 ? $carts->count() : ''}} </strong> <span class="btn_close" style="cursor: pointer;">X</span></h5>
    <hr>
    <div class="cart-details">
        <div class="">
            <div class="DEFAULT">
                @foreach ($carts as $item)
                    <div class="row">
                        <div class="col-3 pr-0 product-image"><img class="img-fluid" src="{{asset($item->course->image)}}"></div>
                        <div class="col-9">
                            <h6 class="product-name">{{$item->course->title}}</h6>
                            <div class="product-pricing"></div>
                            <div class="product-pricing"><strong class="price-container">@lang('lang.rs') {{$item->price}}</strong></div>
                            {{--  <span class="remove " data-id="{{$item['id']}}">
                                <button class="remove_from_cart" data-id="{{$item['id']}}">حذف</button>
                            </span>  --}}
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="subtotal row pb-3">
        <div class="col-9">@lang('lang.total')</div>
        <div class="col-3 text-left"><strong>{{array_sum($carts->pluck('price')->toArray())}}  @lang('lang.rs')</strong></div>
    </div>
    <div class="actions row">
        <div class="col-12 text-right"><a class="btn btn-primary checkout white" href="{{route('checkout')}}">@lang('lang.shopping_cart')</a></div>
    </div>
</div>
@else
    <div class="minicartBox">
        <div class="alert alert-danger text-center">
            <b>@lang('lang.cart_empty')</b>
        </div>
    </div>
@endif

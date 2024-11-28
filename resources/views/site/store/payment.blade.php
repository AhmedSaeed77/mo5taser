@extends('site.includes.master')

@section('content')


<section class="payment-page body-inner">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-md-12">
                <div class="title title-dark">
                    <h3>بيانات الدفع</h3>
                </div>
            </div>
            <!-- /Col -->
            <form action="{{route('site_store_checkout')}}" method="POST">
                @csrf
                <!-- Col -->
                <div class="col-md-8">
                    <div class="form-payment">
                            <div class="form-group">
                                <label>الاسم الثلاثي </label>
                                <input type="text" name="name" required placeholder="اكتب الاسم" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>البريد الالكتروني</label>
                                <input type="email" name="email" required placeholder="example@gmail.com" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>رقم الجوال</label>
                                <input type="tel" name="phone" required placeholder="رقم الجوال" class="form-control" />
                            </div>

                            <div class="title-form">
                                <h3>معلومات اضافية</h3>
                                <span class="line"></span>
                            </div>

                            <div class="form-group">
                                <label>اختر المدينه</label>
                                <input type="text" name="city" required placeholder="المدينة" class="form-control" />

                            </div>
                            <div class="form-group">
                                <label>اختر المنطقه</label>
                                <input type="text" name="area" required placeholder="المنطقه" class="form-control" />

                            </div>
                            <div class="form-group">
                                <label>اختر الحي</label>
                                <input type="text" name="street" required placeholder="الحي" class="form-control" />

                            </div>
                            {{--  <div class="form-group">
                                <button type="submit" class="btn">
                                    <span>التالي</span>
                                </button>
                            </div>  --}}

                    </div>
                </div>
                <!-- /Col -->

                <!-- Col -->
                <div class="col-md-4">
                    <div class="sidebar-payment">
                        <div class="prices">
                            <ul>
                                <li>
                                    <span>السعر: </span>
                                    <span>{{ $product->price }} ر.س</span>
                                </li>
                            </ul>
                        </div>
                        <div class="total">
                            <ul>
                                <li>
                                    <span>إجمالي السعر:</span>
                                    <span><strong>{{ $product->price }} ر.س</strong></span>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="assemble" value="{{$product->id}}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <div class="btn-payment">
                            <button class="btn" type="submit">
                                <span>إتمام الشراء</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
            </form>
        </div>
    </div>
</section>


@endsection

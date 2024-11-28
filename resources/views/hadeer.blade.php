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
            
            <!-- Col -->
            <div class="col-md-8">
                <div class="form-payment">
                    <form action="#">
                        <div class="form-group">
                            <label>الاسم الثلاثي </label>
                            <input type="text" placeholder="اكتب الاسم" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>البريد الالكتروني</label>
                            <input type="email" placeholder="example@gmail.com" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>رقم الجوال</label>
                            <input type="tel" placeholder="رقم الجوال" class="form-control" />
                        </div>
                        
                        <div class="title-form">
                            <h3>معلومات اضافية</h3>
                            <span class="line"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>اختر المدينه</label>
                            <select class="form-control">
                                <option>الرياض</option>
                                <option>الرياض</option>
                                <option>الرياض</option>
                                <option>الرياض</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>اختر المنطقه</label>
                            <select class="form-control">
                                <option>الرياض</option>
                                <option>الرياض</option>
                                <option>الرياض</option>
                                <option>الرياض</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>اختر الحي</label>
                            <select class="form-control">
                                <option>الرحمانيه</option>
                                <option>الرحمانيه</option>
                                <option>الرحمانيه</option>
                                <option>الرحمانيه</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">
                                <span>التالي</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Col -->
            
            <!-- Col -->
            <div class="col-md-4">
                <div class="sidebar-payment">
                    <div class="prices">
                        <ul>
                            <li>
                                <span>السعر الاصلى: </span>
                                <span>1200 ر.س</span>
                            </li>
                            <li>
                                <span>قيمة الخصم: </span>
                                <span>200 ر.س</span>
                            </li>
                        </ul>
                    </div>
                    <div class="total">
                        <ul>
                            <li>
                                <span>إجمالي السعر:</span>
                                <span><strong>1000 ر.س</strong></span>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-payment">
                        <a href="#" class="btn">
                            <span>إتمام الشراء</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </div>
    </div>
</section>


@endsection

@extends('site.includes.master')

@section('content')

<div class="breadcrumbs wow animate__ animate__fadeInUp  animated" style="visibility: visible;">
    <div class="container">
        <a href="https://emary.azq1.com/Mo5tsr" class="home">الرئيسية</a>
        <span class="break">/</span>
        <a href="https://emary.azq1.com/Mo5tsr" class="home">المتجر</a>
        <span class="break">/</span>
        <span class="current">سنجل المتجر</span>
    </div>
</div>

<section class="single_store_page  store-page body-inner">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-md-7 col-sm-6">
                <div class="text-single-h">
                    <h3>كتاب القدرات العامة في اللغة الانجليزية</h3>
                    <div class="price-h">
                        <p>
                            السعر: <strong>30</strong> ريال
                        </p>
                    </div>
                    
                    <div class="downloadChoose">
                        <div class="form-group radioeffect">
                            <input name="radiog_lite" id="radio1" class="css-checkbox radioshow" type="radio" data-class="div1" checked />
                            <label for="radio1" class="css-label radGroup1">نسخة مطبوعة</label>
                        
                            <input name="radiog_lite" id="radio2" class="css-checkbox radioshow" type="radio" data-class="div2" />
                            <label for="radio2" class="css-label radGroup1">نسخة PDF</label>
                        </div>
                        <br>
                        <div class="div1 allshow">
                            <a href="#" class="btn">
                                <span>تحميل</span>
                            </a>
                        </div>
                        <div class="div2 allshow" style="display: none;">
                            <a href="#" class="btn">
                                <span>تحميل</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="tabs-single-h">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabs-single">
                                    عن الكتاب
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs-single2">
                                    تنزيل جزء من الكتاب
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-single">
                                <div class="text-tabs">
                                    <p>
                                        هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-single2">
                                <div class="tabs-single-inner row">
                                    <!-- Col -->
                                    <div class="col-md-6">
                                        <div class="pdf-single-block">
                                            <div class="img">
                                                <img src="{{asset('site/images/pdf.png')}}" alt="#" />
                                            </div>
                                            <div class="details">
                                                <a href="#" class="btn-download">
                                                    <i class="far fa-download"></i>
                                                    <span>تحميل جزء من الكتاب</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Col -->
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Col -->
            
            <!-- Col -->
            <div class="col-md-5 col-sm-6 main_box">
                <div class="box_Gexam">
                    <div class="img-single-h">
                        <img src="{{asset('site/images/single-page.png')}}" alt="#" />
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </div>
    </div>
</section>


@endsection

@extends('site.includes.master')
@section('content')

<!--======================== Start my courses =============================-->
    <section class="my_certificates_page">

        <div class="container">
            <div class="certificates_content" id="result">

                <div class="box_content active">
                    <div class="download_cert noPrint text-center mb-2"  data-html2canvas-ignore="true">
                        <button class="main-btn main download_cert_btn border-0 download">
                        <i class="fas fa-arrow-alt-to-bottom"></i>
                        <span>@lang('lang.download_certificate')</span>
                    </button>
                    </div>
                    <div class="certificate_box">
                        <div class="certificate_design design_two"  style="min-height: 400px;
                        background-image: url({{asset('site/images/certificates/bg_2.png')}});
                        background-repeat: no-repeat;
                        background-size: cover;
                        padding: 20px 25px;    position: relative;
                        border-radius: 13px;
                        overflow: hidden;direction:rtl;">
                                                <div class="inner" style="    border: 1px solid #707070;
                        height: 100%;">
                                <div class="head" style="display: flex;
                        flex-wrap: wrap;
                        align-items: center;
                        padding: 24px 30px 0;">
                                                        <div class="logo" style="    max-width: 30%;
                        flex: 30%;
                        text-align: start;">
                                        <img src="{{asset('site/images/logo.png')}}" alt="" style="    width: 100%;
    max-width: 140px;">
                                        <span class="date" style="display: block;
    color: #111;
    font-family: 'neoBold';
    margin-top: 10px;
    font-size: 12px;        white-space: break-spaces;">@lang('lang.certificate_date') {{ \Carbon\Carbon::parse($subscribe->updated_at)->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="text" style="    max-width: 40%;
    flex: 40%;
    text-align: center;
    font-family: 'neoMed';">
                                        <h4 style="color: #C99A2E;
    font-size: 46px;">@lang('lang.certificate')</h4>
                                        <span style="color: #111;">@lang('lang.certificate_for')</span>
                                    </div>
                                </div>
                                <div class="content_cert text-center" style="padding: 0 60px;text-align: center;">
                                    <h3 class="name" style="    position: relative;
    color: #111;
    font-size: 49px;
    display: inline-block;
    margin: 10px 0 20px;">{{$subscribe->user->name ?? ''}}</h3>
                                    <h5>{{$subscribe->course->title ?? ''}}</h5>
                                    <p style="color: #303030;
    font-size: 14px;
    line-height: 27px;">@lang('lang.certificate_paragraph')</p>
                                </div>
                                <div class="footer_cert" style="    margin: 0 185px 15px 59px;
    display: flex;
    justify-content: flex-end;">
                                    <div class="signature">
                                        <img src="{{asset('site/images/certificates/signature.png')}}" alt="">
                                        <h6 class="name_trainer" style="    font-size: 14px;
    margin: 0;
    padding-top: 6px;
    border-top: 1px solid #ffc107;
    margin-top: 6px;
    font-family: 'neoBold';
    text-align: center;">@lang('lang.mr') / {{$subscribe->course->teachers->first()->name}}</h6>
                                    </div>
                                </div>
                                <div class="shapes_cert">
                                    <img src="{{asset('site/images/certificates/shape_1.png')}}" style="left: auto;
    right: 0;
    bottom: 0;
    height: 200px;    position: absolute;" alt="">
                                    <img src="{{asset('site/images/certificates/shape_2.png')}}" style="right: auto;
    left: 0;
    top: 0;position: absolute; height: 200px;" alt="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--======================== End my courses =============================-->

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script>
    $(()=>{
        $('.download').on('click',function(){
            var element = document.getElementById('result');
                var opt = {
                margin:       1,
                filename:     'certificate.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
        });
    });
</script>


@endsection

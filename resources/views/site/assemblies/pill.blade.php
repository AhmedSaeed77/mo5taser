@extends('site.includes.master')

@section('content')


<section class="pill-page" id="result">
    <div class="pill-inner" style="
    max-width: 934.79px;
    margin: 0 auto;
    padding: 50px 0;
">
        <table style="
    width: 100%;
">
            <thead>
                <tr>
                    <td colspan="3" style="
    text-align: right;
    border-bottom: 1px #BCBCBC solid;
    padding-bottom: 10px;
">
                        <h3 style="
    color: #484848;
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 30px;
">معهد المختصر الشامل </h3>
                        <ul>
                            <li style="
    font-weight: 500;
    margin: 12px 0;
    font-size: 16px;
    color: #343434;
">
                                <strong>{{$info->address ?? ''}}</strong>
                            </li>
                            <li style="
    font-weight: 500;
    margin: 12px 0;
    font-size: 16px;
    color: #343434;
">
                                <strong>{{$info->email ?? ''}}</strong>
                            </li>
                            <li style="
    font-weight: 500;
    margin: 12px 0;
    font-size: 16px;
    color: #61646B;
">
@lang('lang.tax_number') : {{$info->tax_number ?? ''}}
                            </li>
                        </ul>
                    </td>

                    <td colspan="3" style="
    text-align: left;
    border-bottom: 1px #BCBCBC solid;
    padding-bottom: 10px;
">
                        <h3 style="
    color: #484848;
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 30px;
">Almokhtasar Alshamil Institute </h3>
                        <ul>
                            <li style="
    font-weight: 500;
    margin: 12px 0;
    font-size: 16px;
    color: #343434;
">
                                <strong>{{$info->address ?? ''}} </strong>
                            </li>
                            <li style="
    font-weight: 500;
    margin: 12px 0;
    font-size: 16px;
    color: #343434;
">
                                <strong>{{$info->email ?? ''}}</strong>
                            </li>
                            <li style="
    margin: 12px 0;
    font-size: 16px;
    color: #61646B;
">
                                @lang('lang.tax_number') : {{$info->tax_number ?? ''}}
                            </li>
                        </ul>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="
    padding: 15px 0;
    text-align: right;
    border-bottom: 1px #BCBCBC solid;
">
                        <p style="
    color: #61646B;
    font-size: 16px;
">
                            <strong style="
    color: #343434;
">رقم الفاتوره :</strong>
                            986437
                        </p>
                    </td>

                    <td colspan="3" style="
    padding: 15px 0;
    text-align: left;
    border-bottom: 1px #BCBCBC solid;
">
                        <p style="
    color: #61646B;
    font-size: 16px;
">
                            <strong style="
    color: #343434;
">@lang('lang.created_at') :</strong>
                            {{$payment->created_at->format('Y-m-d H:i')}}
                        </p>
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="3" style="
    padding: 25px 0;
">
                        <ul>
                            <li style="
    color: #61646B;
    font-size: 16px;
    margin: 12px 0;
">
                                <strong style="
    color: #343434;
"> @lang('lang.user') :</strong>
                                {{$payment->name ?? ''}}
                            </li>
                            <li style="
    color: #61646B;
    font-size: 16px;
    margin: 12px 0;
">
                                <strong style="
    color: #343434;
"> @lang('lang.phone') :</strong>
{{$payment->phone ?? ''}}
                            </li>
                            <li style="
    color: #61646B;
    font-size: 16px;
    margin: 12px 0;
">
                                <strong style="
    color: #343434;
">@lang('lang.area') :</strong>
{{$payment->area ?? ''}}
                            </li>
                            <li style="
    color: #61646B;
    font-size: 16px;
    margin: 12px 0;
">
                                <strong style="
    color: #343434;
">@lang('lang.city') :</strong>
                                {{$payment->city ?? ''}}
                            </li>
                            <li style="
    color: #61646B;
    font-size: 16px;
    margin: 12px 0;
">
                                <strong style="
    color: #343434;
">@lang('lang.street') :</strong>
                                {{$payment->street ?? ''}}
                            </li>
                        </ul>
                    </td>

                    <td colspan="3" style="
    padding: 25px 0;
    text-align: left;
">
                        <div class="qR" style="
    width: 194px;
    text-align: left;
    display: inline-block;
">
{!! QrCode::encoding('UTF-8')->size(300)->generate($all)!!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table style="
    width: 100%;
    border: 0.96px solid #868686;
">
                            <thead>
                                <tr>
                                    <th style="
    background: #B2E5F4;
    padding: 12px;
    text-align: center;
    color: #343434;
    font-size: 16px;
    border: 1px #868686 solid;
    font-weight: 500;
">@lang('lang.product_name')</th>
                                    <th style="
    background: #B2E5F4;
    padding: 12px;
    text-align: center;
    color: #343434;
    font-size: 16px;
    border: 1px #868686 solid;
    font-weight: 500;
">@lang('lang.price')</th>
                                    <th style="
    background: #B2E5F4;
    padding: 12px;
    text-align: center;
    color: #343434;
    font-size: 16px;
    border: 1px #868686 solid;
    font-weight: 500;
">@lang('lang.tax')</th>
                                    <th style="
    background: #B2E5F4;
    padding: 12px;
    text-align: center;
    color: #343434;
    font-size: 16px;
    border: 1px #868686 solid;
    font-weight: 500;
">@lang('lang.price_after_tax')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="
    border: 0.96px solid #868686;
    padding: 12px;
    height: 40px;
">{{$payment->assemble->title}}</td>
                                    <td style="
    border: 0.96px solid #868686;
    padding: 12px;
    height: 40px;
">{{$payment->price}}</td>
                                    <td style="
    border: 0.96px solid #868686;
    padding: 12px;
    height: 40px;
"> 15 % </td>
                                    <td style="
    border: 0.96px solid #868686;
    padding: 12px;
    height: 40px;
">{{$payment->price}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    {{--  <td colspan="6" style="
    padding-top: 40px;
    color: #343434;
    font-size: 16px;
    font-weight: 500;
">
                        <strong>اجمالي المبلغ :</strong>
                    </td>  --}}
                </tr>
                <tr>
                    {{--  <td colspan="6" style="
    padding-top: 15px;
    color: #343434;
    font-size: 16px;
    font-weight: 500;
">
                        <strong>اجمالي الخصم :</strong>
                    </td>  --}}
                </tr>
                <tr>
                    {{--  <td colspan="6" style="
    padding-top: 15px;
    color: #343434;
    font-size: 16px;
    font-weight: 500;
">
                        <strong>الضريبه المضافه :</strong>
                    </td>  --}}
                </tr>
                {{--  <tr>
                    <td colspan="6" style="
    padding-top: 15px;
    color: #343434;
    font-size: 16px;
    font-weight: 500;
">
                        <strong>المستحق :</strong>
                    </td>
                </tr>
                <tr>  --}}
                    <td colspan="6" style="
    padding-top: 15px;
    color: #343434;
    font-size: 16px;
    font-weight: 500;
">
                        <div class="btn-group" style="
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    -webkit-align-items: center;
        margin: 30px 0 0;
">
                            {{--  <a href="#" class="btn-down" download="" style="
    min-width: 199.42px;
    text-align: center;
    min-height: 48px;
    background: #29b4e3;
    color: #fff;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    padding: 10px;
    margin-inline-end: 30px;
">
                                تحميل الفاتوره
                            </a>  --}}
                            <button class="btn-print download"  data-html2canvas-ignore="true" style="
    min-width: 199.42px;
    text-align: center;
    min-height: 48px;
    background: #EBEBEB;
    color: #343434;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    padding: 10px;
    margin-inline-end: 30px;
">
                                @lang('lang.download')
                            </button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>


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
                filename:     'pill.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
        });
    });
</script>
@endsection

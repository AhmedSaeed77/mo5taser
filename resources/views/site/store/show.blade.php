@extends('site.includes.master')
@section('content')

<!--========================== Start page header =============================-->
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <span class="current">@lang('lang.store')</span>
    </div>
</div>
<!--========================== End page header =============================-->


<section class="single_store_page  store-page body-inner">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-md-7 col-sm-6">
                <div class="text-single-h">
                    <h3>{{$product->title}}</h3>
                    <div class="price-h">
                        <p>
                            @lang('lang.price') : <strong> {{$product->price}} </strong> @lang('lang.rs')
                        </p>
                    </div>

                    <div class="downloadChoose">
                        <div class="form-group radioeffect">
                            <input name="radiog_lite" value="printed" id="radio1" class="css-checkbox radioshow" type="radio" data-class="div1" checked />
                            <label for="radio1" class="css-label radGroup1">@lang('lang.printed version')</label>

                            <input name="radiog_lite" value="pdf" id="radio2" class="css-checkbox radioshow" type="radio" data-class="div2" />
                            <label for="radio2" class="css-label radGroup1">@lang('lang.Pdf Version')</label>
                        </div>
                        <br>
                        <div class="div1 allshow">
                            <a href="{{route('site_store_buy',[$product->id , 'printed'])}}" class="btn">
                                <span>@lang('lang.buy')</span>
                            </a>
                        </div>
                        <div class="div2 allshow" style="display: none;">
                            <a href="{{route('site_store_buy',[$product->id , 'pdf'])}}" class="btn">
                                <span>@lang('lang.buy')</span>
                            </a>
                        </div>
                    </div>

                    <div class="tabs-single-h">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabs-single">
                                    @lang('lang.about_book')
                                </button>
                            </li>
                            @if($product->book_preview !== null)
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabs-single2">
                                        @lang('lang.Download part of the book')
                                    </button>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-single">
                                <div class="text-tabs">
                                    <p>{{$product->content}}</p>
                                </div>
                            </div>

                            @if($product->book_preview !== null)
                                <div class="tab-pane fade" id="tabs-single2">
                                    <div class="tabs-single-inner row">
                                        <!-- Col -->
                                        <div class="col-md-6">
                                            <div class="pdf-single-block">
                                                <div class="img">
                                                    <img src="{{asset('site/images/pdf.png')}}" alt="#" />
                                                </div>
                                                <div class="details">
                                                    <a href="{{asset($product->book_preview)}}" class="btn-download" download>
                                                        <i class="far fa-download"></i>
                                                        <span> @lang('lang.Download part of the book') </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Col -->
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Col -->

            <!-- Col -->
            <div class="col-md-5 col-sm-6 main_box">
                <div class="box_Gexam">
                    <div class="img-single-h">
                        <img src="{{asset($product->image)}}" alt="#" />
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </div>
    </div>
</section>

@endsection

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

<!--========================== Start general exams page =============================-->
<section class="general_exams_page mt-40 mb-40 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 mb-30">@lang('lang.store')</h4>
        <div class="row">
            <div class="col-lg-12 mt-md-30">
                <div class="main_content">
                    @if ($products->count() > 0)
                        <div class="row">
                            @foreach ($products as $key => $product)
                                <div class="col-md-4 col-sm-6 main_box">
                                    <div class="box_Gexam">
                                        <div class="image">
                                            <img src="{{asset($product->image)}}" alt="#" />
                                        </div>
                                        <div class="info">
                                            <h6 class="name text-ellipsis">{{$product->title}}</h6>
                                            <div class="details">
                                                <p>{{ \Illuminate\Support\Str::limit($product->content, 100, '') }}</p>
                                            </div>
                                            <a href="{{route('site_store_show',$product->id)}}" class="main-btn trans w-100">
                                                @lang('lang.show')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-danger text-center">
                            <b>@lang('lang.no_products')</b>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
<!--========================== End general exams page =============================-->

@endsection

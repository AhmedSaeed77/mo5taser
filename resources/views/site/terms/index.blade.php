@extends('site.includes.master')
@section('content')
<!--========================== Start terms page =============================-->
    <section class="terms_page mt-40 mb-40 wow animate__animated animate__fadeInUp">
        <div class="container">
            <h4 class="main_heading main-color mb-60 bold text-center">@lang('lang.term')</h4>
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_section">
                        @if($terms->count() > 0)
                            @foreach ($terms as $term)
                                <div class="block mb-30">
                                    <h5 class="head mb-20">{{$term->title}}</h5>
                                    <p class="desc m-0">{!! $term->content !!}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========================== End terms page =============================-->

@endsection

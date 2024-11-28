@extends('site.includes.master')
@section('content')

<section class="login_page">
    <div class="container">
        <div class="form_modal wow animate__animated animate__fadeInUp">
            <div class="row no-gutters">
                <div class="col-lg-7 o-2">
                    <form method="POST" action="{{ route('join-teacher.store') }}" class="form_box" enctype="multipart/form-data">
                        @csrf
                        <h5 class="head mb-30">@lang('lang.join_now')</h5>
                        <div class="form-group">
                            <label for="">@lang('lang.name')</label>
                            <div class="input_form">
                                <span class="icon"><i class="la la-book"></i></span>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">@lang('lang.email')</label>
                            <div class="input_form">
                                <span class="icon"><i class="la la-envelope"></i></span>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">@lang('lang.cv')</label>
                            <div class="input_form">
                                <input type="file" class="form-control" name="cv"
                                accept="application/pdf" value="{{ old('cv') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="main-btn main">@lang('lang.send')</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="image h-100">
                        <img src="{{asset($image->image_join_us ?? 'site/images/teacher.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@extends('site.includes.master')
@section('content')
<!--========================== Start contact page =============================-->
<section class="contact_page">
    <div class="container">
        <div class="content">
            <div class="form_modal">
                <div class="row">
                    <div class="col-lg-6 border_e">
                        <h5 class="head">@lang('lang.contact_us')</h5>
                        <form action="{{route('site.contact.store')}}" method="POST" >
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="">@lang('lang.name')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="la la-user"></i></span>
                                    <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="@lang('lang.name')" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('lang.email')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="la la-envelope"></i></span>
                                    <input type="email" name="email" value="{{old('email')}}"  class="form-control" placeholder="@lang('lang.email')" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('lang.phone')</label>
                                <div class="input_form">
                                    <span class="icon"><i class="las la-phone-volume"></i></span>
                                    <input type="number"  name="phone" value="{{old('phone')}}" class="form-control" placeholder="@lang('lang.phone')" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">@lang('lang.msg')</label>
                                <textarea class="form-control" name="msg" style="height: 100px; resize: none; box-shadow: none;" placeholder="@lang('lang.msg')" required>{{old('phone')}}</textarea>
                            </div>
                            <div class="form-group m-0">
                                <button class="main-btn main border-0" type="submit">@lang('lang.submit')</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 contact_info">
                        <h5 class="head">@lang('lang.socail_contact')</h5>
                        <div class="items">
                            <a href="tel:{{$info->phone ?? ''}}" class="item">
                                <span class="icon"><i class="las la-phone-volume"></i></span>
                                <span class="text">{{$info->phone ?? ''}}</span>
                            </a>
                            <a href="mailto:{{$info->email ?? ''}}" class="item">
                                <span class="icon"><i class="la la-envelope"></i></span>
                                <span class="text">{{$info->email ?? ''}}</span>
                            </a>
                            <a href="https://maps.google.com?q={{$info->address ?? ''}}" target="_blank" class="item">
                                <span class="icon"><i class="las la-map-marker-alt"></i></span>
                                <span class="text">{{$info->{'address_'.app()->getLocale()} ?? ''}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== End contact page =============================-->

@endsection

@extends('site.includes.master')
@section('content')
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <a href="{{route('courses')}}" class="home">@lang('lang.courses')</a>
    </div>
</div>
<x-course></x-course>
@endsection

@extends('site.includes.master')
@section('content')

<!--========================== Start profile page =============================-->
<section class="exams_page mt-60 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 text-center">{{$title}}</h4>
        <div class="row content_section mt-80">
            @if($exams->count() > 0)
                @foreach ($exams as $exam)
                    @php
                       $attempts = \App\Models\StudentExam::where(['user_id' => auth()->id(),'status' => 0,])
                       ->where('exam_id',$exam->id)->get();
                    @endphp
                    @if($attempts->count() > 0)
                        <div class="col-lg-4 col-md-6">
                            <div class="exam_box">
                                <h6 class="name">{{$exam->mainCat->title}} / {{$exam->levelCat->title}}</h6>
                                <div class="info">
                                    <div class="item">
                                        <span>@lang('lang.attempts_count') :</span>
                                        <span>{{$attempts->count()}}</span>
                                    </div>
                                    <div class="item">
                                        <span>@lang('lang.rest') :</span>
                                        <span>{{$exam->attemps - $attempts->count()}}</span>
                                    </div>
                                    {{--  <div class="item">
                                        <span>@lang('lang.total_average') :</span>
                                        <span class="badge">70%</span>
                                    </div>  --}}
                                    <div class="meta">
                                        @if($exam->attemps - $attempts->count() > 0)
                                          <a href="{{route('enter_exam',$exam->id)}}" class="btn-form">@lang('lang.make_an_attempt')</a>
                                        @endif
                                        <a href="{{route('attempts.details',$exam->id)}}" class="main-btn trans">@lang('lang.show_attempts')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>
<!--========================== End profile page =============================-->

@endsection

@extends('site.includes.master')
@section('content')
<!--========================== Start myProfile page =============================-->
    <section class="myProfile_page paddingPage">
        <div class="container">
            <div class="profile_flex">
                <div class="profileCard">
                    <ul class="list">
                        <li class="mou_tab active" data-content="my_Information">
                            <i class="las la-user-edit"></i>
                            <span>@lang('lang.my_infos')</span>
                        </li>
                        {{--  <li class="mou_tab" data-content="my_messages">
                            <i class="las la-comment-dots"></i>
                            <span>الرسائل</span>
                            <span class="noti flex-center">2</span>
                        </li>  --}}
                        <li class="mou_tab" data-content="account_statement">
                            <i class="las la-credit-card"></i>
                            <span>@lang('lang.Account statement')</span>
                        </li>
                        <li class="mou_tab" data-content="certificates_section">
                            <i class="las la-certificate"></i>
                            <span>@lang('lang.certificates')</span>
                        </li>
                        <li class="mou_tab" data-content="markiting_section">
                            <i class="lab la-digital-ocean"></i>
                            <span>@lang('lang.Affiliate Marketing')</span>
                        </li>
                        <li class="mou_tab" data-content="exchanges">
                            <i class="lab la-digital-ocean"></i>
                            <span>@lang('lang.exchanges')</span>
                        </li>
                    </ul>
                </div>
                <div class="main_content">
                    <div class="box_content active" id="my_Information">
                        <div class="section_content col-lg-7 p-0">
                            <h3 class="heading_2 mb-40">@lang('lang.my_infos')</h3>
                            <form action="{{route('user.update',auth()->id())}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">@lang('lang.name')</label>
                                    <div class="input_box">
                                        <input type="text" placeholder="@lang('lang.name')" name="name" value="{{auth()->user()->name}}" readonly required>
                                        <span class="icon flex-center"><i class="las la-pen"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('lang.email')</label>
                                    <div class="input_box">
                                        <input type="text" placeholder="@lang('lang.email')" name="email" value="{{auth()->user()->email}}" readonly required>
                                        <span class="icon flex-center"><i class="las la-pen"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('lang.phone')</label>
                                    <div class="input_box">
                                        <input type="text" placeholder="@lang('lang.phone')" name="phone" value="{{auth()->user()->phone}}" readonly required>
                                        <span class="icon flex-center"><i class="las la-pen"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('lang.edit_password')</label>
                                    <div class="input_box">
                                        <input type="password" placeholder="@lang('lang.password')" name="password" readonly required>
                                        <span class="icon flex-center"><i class="las la-pen"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">@lang('lang.image')</label>
                                    <div class="input_box">
                                        <input type="file" placeholder="@lang('lang.image')" name="image" accept="image/*">
                                    </div>
                                    <span style="color: red">@lang('lang.optional')</span>
                                    <br>
                                    <img class="img-thumbnail" src="{{asset(auth()->user()->image)}}" style="width: 100px; height: 100px;">
                                </div>
                                <input type="hidden" name="user" value="{{auth()->user()->id}}">
                                <div class="form-group meta">
                                    <button type="submit" class="main-btn main" >@lang('lang.update')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box_content" id="my_messages">
                        <h3 class="text-center bold">قريبا</h3>
                    </div>
                    <div class="box_content" id="account_statement">
                        <div class="section_content col-lg-12 mb-30 p-0">
                            <h3 class="heading_2 mb-40">@lang('lang.Account statement')</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="earn_box">
                                        <h6 class="head">@lang('lang.comming profits')</h6>
                                        <div class="earned">
                                            <span class="num">{{$incomming_profits}}</span>
                                            <span class="text">@lang('lang.rs')</span>
                                        </div>
                                        {{--  <a href="#" class="main-btn sec">سحب الارباح</a>  --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="earn_box">
                                        <h6 class="head">@lang('lang.exchangeable profits')</h6>
                                        <div class="earned">
                                            <span class="num">{{auth()->user()->balance - $not_accepted_profits}}</span>
                                            <span class="text">@lang('lang.rs')</span>
                                        </div>
                                        @if($info && auth()->user()->balance - $not_accepted_profits > $info->min_profit)
                                        <a data-bs-toggle="modal" data-bs-target="#madyModal" class="main-btn sec">@lang('lang.Withdraw profits')</a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="financial_trans">
                            <h4 class="head">@lang('lang.Account statement')</h4>
                            <div class="financial_table">
                                <div class="content_table">
                                    <div class="row_item row_head">
                                        <div class="box">@lang('lang.course')</div>
                                        <div class="box">@lang('lang.user')</div>
                                        <div class="box">@lang('lang.coupon')</div>
                                        <div class="box">@lang('lang.difference')</div>
                                        <div class="box">@lang('lang.created_at')</div>
                                    </div>
                                    @if ($subscribes->count() > 0)
                                        @foreach ($subscribes as $subscribe)
                                            <div class="row_item">
                                                <div class="box desc">
                                                    <p class="m-0">{{$subscribe->course->title}}</p>
                                                </div>
                                                <div class="box type">
                                                    <p class="m-0">{{$subscribe->user->name}}</p>
                                                </div>
                                                <div class="box price">
                                                    <p class="m-0 main-color">{{$subscribe->coupon}}</p>
                                                </div>
                                                <div class="box status">
                                                    <span class="flex-center sure">{{$subscribe->difference}} @lang('lang.rs')</span>
                                                </div>
                                                <div class="box date">
                                                    <span>{{$subscribe->created_at->format('Y-m-d')}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box_content" id="certificates_section">
                        <div class="section_content">
                            <h3 class="heading_2 mb-30">@lang('lang.certificates')</h3>
                            <div class="row">
                                @if ($certificates->count() > 0)
                                    @foreach ($certificates as $certificate)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="cert_box">
                                                <div class="image">
                                                    <img src="{{asset($certificate->course->image)}}" alt="">
                                                </div>
                                                <div class="info">
                                                    <div class="name">
                                                        <p>@lang('lang.certificate_in')</p>
                                                        <p>({{$certificate->course->title}})</p>
                                                    </div>
                                                    <a href="{{route('certificate',$certificate->id)}}" class="main-btn trans" target="_blank">@lang('lang.show_certificate')</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                  <div class="alert alert-danger text-center">
                                      <b>@lang('lang.no_certificates')</b>
                                  </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box_content" id="markiting_section">
                        <div class="section_content">
                            <h3 class="heading_2 mb-40">@lang('lang.Affiliate Marketing')</h3>
                        </div>
                        <div class="markiting_table">
                            <div class="table_content">
                                <div class="row_item row_head">
                                    <div class="box text-center">@lang('lang.discount percentage') % </div>
                                    <div class="box text-center">@lang('lang.discount_number')</div>
                                    <div class="box text-center">@lang('lang.discount code')</div>
                                    <div class="box text-center">@lang('lang.course')</div>
                                    <div class="box text-center">@lang('lang.use_number')</div>
                                </div>
                                @if ($coupons->count() > 0)
                                    @foreach ($coupons as $coupon)
                                        <div class="row_item">
                                            <div class="box text-center">{{$coupon->discount}} </div>
                                            <div class="box text-center">{{$coupon->discount_number}} </div>
                                            <div class="box text-center">{{$coupon->coupon}}</div>
                                            <div class="box text-center">{{$coupon->course->title}}</div>
                                            <div class="box text-center">{{$coupon->use_number}}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box_content" id="exchanges">
                        <div class="section_content">
                            <h3 class="heading_2 mb-40">@lang('lang.exchanges')</h3>
                        </div>
                        <div class="markiting_table financial_trans">
                            <div class="financial_table">
                                <div class="table_content">
                                    <div class="row_item row_head">
                                        <div class="box">@lang('lang.user')</div>
                                        <div class="box">@lang('lang.phone')</div>
                                        <div class="box">@lang('lang.image_transfer')</div>
                                        <div class="box">@lang('lang.amount')</div>
                                        <div class="box">@lang('lang.all balance')</div>
                                        <div class="box">@lang('lang.status')</div>
                                        <div class="box">@lang('lang.created_at')</div>
                                    </div>
                                    @if ($exchanges->count() > 0)
                                        @foreach ($exchanges as $exchange)
                                            <div class="row_item">
                                                <div class="box type">
                                                    <p class="m-0">{{$exchange->user->name}}</p>
                                                </div>
                                                <div class="box type">
                                                    <p class="m-0">{{$exchange->user->phone}}</p>
                                                </div>
                                                <div class="box type">
                                                    @if ($exchange->image_transfer)
                                                    <a href="{{asset($exchange->image_transfer)}}" target="_blank" class="m-0">
                                                        <img src="{{asset($exchange->image_transfer)}}" style="width: 60px; height: 60px;">
                                                    </a>
                                                    @else
                                                     ----
                                                    @endif
                                                </div>
                                                <div class="box price">
                                                    <p class="m-0 main-color">{{$exchange->amount}} @lang('lang.rs')</p>
                                                </div>
                                                <div class="box type">
                                                    <p class="m-0">{{auth()->user()->balance}}</p>
                                                </div>
                                                <div class="box type">
                                                    <p class="m-0">{{__('lang.'.$exchange->status)}}</p>
                                                    <p class="m-0">{{$exchange->paid == 1 ? __('lang.paid') : __('lang.unpaid')}}</p>
                                                </div>
                                                <div class="box date">
                                                    <span>{{$exchange->created_at->format('Y-m-d')}}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade cancelNow  madyModal" id="madyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="form-modal">
                    <div class="title title-center">
                        <h3>@lang('lang.Withdraw profits')</h3>
                    </div>
                    <form action="{{route('exchange-request')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>@lang('lang.amount')</label>
                            <input type="number" min="1" max="{{auth()->user()->balance - $not_accepted_profits}}" name="amount" class="form-control" placeholder="@lang('lang.amount')" required/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">@lang('lang.submit')</button>
                        </div>

                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    <!--========================== End myProfile page =============================-->

@endsection

@extends('site.includes.master')
@section('content')

<!--========================== Start notifications page =============================-->
<section class="notifications_page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="head  flex-center-h">
                    <h4 class="main-color m-0">@lang('lang.notifications')</h4>
                    @if (Auth::user()->Notifications()->get()->count() > 0)
                    <button class="delete_all" data-bs-toggle="modal" data-bs-target="#deleteNoti_Modal">
                        <i class="las la-trash"></i>
                        <span>@lang('lang.delete_all')</span>
                    </button>
                    @endif
                </div>
                <div class="content_noti">
                    @if (Auth::user()->Notifications()->get()->count() > 0)
                        @foreach (Auth::user()->Notifications()->get() as $not)
                            @if ($not->type == 'App\Notifications\GetCertificateUser')
                                <div class="item  flex-center-h">
                                    <a href="{{route('profile')}}">
                                        <p class="text m-0">@lang('lang.get_certificate')</p>
                                    </a>
                                </div>
                                @endif
                            @if ($not->type == 'App\Notifications\removeCertificateUser')
                                <div class="item  flex-center-h">
                                    <a href="{{route('profile')}}">
                                        <p class="text m-0">@lang('lang.get_certificate')</p>
                                    </a>
                                </div>
                            @endif
                            @if ($not->type == 'App\Notifications\activeSubscribtion')
                                <div class="item  flex-center-h">
                                    <a href="{{route('my-courses')}}">
                                        <p class="text m-0">@lang('lang.activeSubscribtion')</p>
                                    </a>
                                </div>
                            @endif
                            @if ($not->type == 'App\Notifications\unActiveSubscribtion')
                                <div class="item  flex-center-h">
                                    <a href="{{route('my-courses')}}">
                                        <p class="text m-0">@lang('lang.unActiveSubscribtion')</p>
                                    </a>
                                </div>
                            @endif
                            @if ($not->type == 'App\Notifications\StudentTestCorrection')
                                <div class="item  flex-center-h">
                                    <a href="{{route('exam-attempts-site', $not->data['id'])}}">
                                        <p class="text m-0">@lang('lang.you passed exam')</p>
                                    </a>
                                </div>
                            @endif
                        @endforeach

                    @else
                    <a href="#" class="all_noti">@lang('lang.no_unread_notifications')</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== End notifications page =============================-->

<!--========================= Start delete product modal =========================-->
    <div class="modal fade custom_modal" id="deleteNoti_Modal" tabindex="-1" role="dialog" aria-labelledby="deleteNoti_Modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal_header">
                    <h5 style="color: #000;">@lang('lang.sure_delete_all_notifications')</h5>
                </div>
                <div class="modal-footer">
                    <form action="{{route('delete.notifications')}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-form" data-bs-dismiss="modal">
                                    <span>@lang('lang.back')</span>
                                    <i class="far fa-level-down"></i>
                                </button>
                        <button type="submit" class="btn-form close">
                                    <span>@lang('lang.delete')</span>
                                    <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--========================= End delete product modal =========================-->

@endsection

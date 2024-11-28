<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                @if (auth('admin')->user()->role->name == 'admin' || auth('admin')->user()->role->name == 'super_admin')
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-user"></i><span>@lang('lang.members')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('users.index')}}">@lang('lang.users')</a></li>
                                <li><a href="{{route('admins.index')}}">@lang('lang.teachers') & @lang('lang.admins')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-list"></i><span>@lang('lang.categories')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{url('admin/category/course')}}">@lang('lang.course_categories')</a></li>
                                <li><a href="{{url('admin/category/assemblies')}}">@lang('lang.assemblies_categories')</a></li>
                                <li><a href="{{url('admin/category/contest')}}">@lang('lang.contest_categories')</a></li>
                                <li><a href="{{url('admin/category/exam')}}">@lang('lang.exam_categories')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-book"></i><span>@lang('lang.passed_contest_exam')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('pass.index')}}">@lang('lang.passed_exam')</a></li>
                                <li><a href="{{route('pass-contest.index')}}">@lang('lang.passed_contests')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            @php
                              $un_active_subscribtion = count(\App\Models\Subscribe::where(['active' => 0 , 'start_subscribe' => null , 'end_subscribe' => null])->get());
                            @endphp
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-book"></i>
                                @if($un_active_subscribtion > 0)
                                <span>@lang('lang.courses')</span>
                                <span class="label label-danger pull-right">{{ $un_active_subscribtion }}</span>
                                @else
                                <span>@lang('lang.courses')</span><span class="menu-arrow"></span>
                                @endif
                            </a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('courses.index')}}">@lang('lang.courses')</a></li>
                                <li><a href="{{route('coupon.index')}}">@lang('lang.coupons')</a></li>
                                <li><a href="{{route('admin.filter','course')}}">@lang('lang.a course')</a></li>
                                <li><a href="{{route('subscribes-courses','un-active')}}">@lang('lang.course buy requests')</a></li> {{--@lang('lang.un_active_subscribes')--}}
{{--                                <li><a href="{{route('subscribes-courses','finished')}}">@lang('lang.finished_subscribes')</a></li>--}}
{{--                                <li><a href="{{route('admin.filter','product')}}">@lang('lang.product')</a></li>--}}
                                <li><a href="{{route('admin.filter','nonSubscribers')}}">@lang('lang.non_subscribers')</a></li>
{{--                                <li><a href="{{route('subscribes-courses','active')}}">@lang('lang.active_subscribes')</a></li>--}}
                                {{--  <li><a href="{{route('subscribes.index')}}">@lang('lang.subscribes')</a></li>  --}}
                                <li><a href="{{route('bank.index')}}">@lang('lang.banks')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-book"></i><span>@lang('lang.store')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('store.index')}}">@lang('lang.store')</a></li>
                                <li><a href="{{route('store-requests.index')}}">@lang('lang.store_requests')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-book"></i><span>@lang('lang.assemblies')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('assemble.index')}}">@lang('lang.assemblies')</a></li>
{{--                                <li><a href="{{route('assembles-requests.index')}}">@lang('lang.assemblies_requests')</a></li>--}}
                            </ul>
                        </li>
                        <li class="has_sub">
                            @php
                              $new_exchange = count(\App\Models\Exchange::where(['status' => 'un_read'])->get());
                            @endphp
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-money"></i>
                                @if($new_exchange > 0)
                                <span>@lang('lang.exchanges')</span>
                                <span class="label label-danger pull-right">{{ $new_exchange }}</span>
                                @else
                                <span>@lang('lang.exchanges')</span><span class="menu-arrow"></span>
                                @endif
                            </a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('exchange.index')}}">@lang('lang.exchanges')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-list"></i><span>@lang('lang.subjects')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('subject.index')}}">@lang('lang.subjects')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-book"></i><span>@lang('lang.about_us')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('about.index')}}">@lang('lang.about_us')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-user"></i><span>@lang('lang.team')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('team.index')}}">@lang('lang.team')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-pencil"></i><span>@lang('lang.testimonail')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('testimonail.index')}}">@lang('lang.testimonail')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-pencil"></i><span>@lang('lang.specs')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('spec.index')}}">@lang('lang.specs')</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            @php
                            $msg_count = count(\App\Models\Contact::where('status', 'unread')->get());
                            @endphp
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-comment"></i>
                                @if($msg_count > 0)
                                <span class="label label-danger pull-right">{{ $msg_count }}</span>
                                @endif
                                <span>@lang('lang.contact_us')</span></a>

                                <ul class="list-unstyled">
                                    <li><a href="{{route('contact.index')}}">@lang('lang.contact_us')</a></li>
                                </ul>
                        </li>
                        <li class="has_sub">
                            @php
                            $join_teacher = count(\App\Models\Join::where('status', 'unread')->get());
                            @endphp
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-pencil"></i>
                                @if($join_teacher > 0)
                                <span class="label label-danger pull-right">{{ $join_teacher }}</span>
                                @endif
                                <span>@lang('lang.join_teacher')</span></a>

                                <ul class="list-unstyled">
                                    <li><a href="{{route('join.index')}}">@lang('lang.join_teacher')</a></li>
                                </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i
                                    class="ti-pencil"></i><span>@lang('lang.site_content')</span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('info.index')}}">@lang('lang.infos')</a></li>
                                <li><a href="{{route('image.index')}}">@lang('lang.images')</a></li>
                                <li><a href="{{route('why-us.index')}}">@lang('lang.why_us')</a></li>
                                <li><a href="{{route('slider.index')}}">@lang('lang.slider')</a></li>
                                <li><a href="{{route('news.index')}}">@lang('lang.news')</a></li>
                                <li><a href="{{route('privacy.index')}}">@lang('lang.privacy')</a></li>
                                <li><a href="{{route('term.index')}}">@lang('lang.term')</a></li>
{{--                                <li><a href="{{route('user-messages.index')}}">@lang('lang.user_messages')</a></li>--}}
                            </ul>
                        </li>
                @endif
                @if (auth('admin')->user()->role->name == 'teacher')
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-marker-alt"></i><span>
                                @lang('lang.passed_contest_exam') </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('passed-exams.index')}}">@lang('lang.passed_contest_exam')</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-marker-alt"></i><span>
                                @lang('lang.courses') </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->

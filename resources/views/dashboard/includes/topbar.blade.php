<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <!-- <a href="{{route('admin.dashboard')}}" class="logo"><i class="icon-magnet icon-c-logo"></i><span>Ub<i class="md md-album"></i>ld</span></a> -->
            <!-- Image Logo here -->
            <a href="{{route('admin.dashboard')}}" class="logo">
                <i class="icon-c-logo"> <img src="{{ asset('dashboard/images/Artboard_5 .png') }}"
                        style="width: 85%; height: 42px; object-fit: cover;" /> </i>
                <span><img src="{{ asset('dashboard/images/Artboard_5 .png') }}"
                        style="height: auto; width: 100%;" /></span>
            </a>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="md md-menu"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>


                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="dropdown top-menu-item-xs">
                        @if (App::isLocale('ar'))
                            <a class="waves-effect waves-light" href="{{ url('/') }}/lang/en">
                                en
                            </a>
                        @else
                            <a class="waves-effect waves-lightk" href="{{ url('/') }}/lang/ar">
                                ar
                            </a>
                        @endif
                    </li>
                    <li class="dropdown top-menu-item-xs">
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <i class="icon-bell"></i>
                            @if (count(auth('admin')->user()->unreadnotifications))
                                <span class="badge badge-xs badge-danger">{{ count(auth('admin')->user()->unreadnotifications) }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg">
                            @if (count(auth('admin')->user()->Notifications) > 0)
                                @foreach (auth('admin')->user()->unReadNotifications as $not)
                                    @if ($not->type == 'App\Notifications\passTest')
                                        @php
                                            $main = \App\Models\Category::where('id', $not->data['main_cat'])->first();
                                            $level = \App\Models\Category::where('id', $not->data['level'])->first();
                                        @endphp

                                        {{-- uread notification --}}
                                        <a href="{{ route('teacher.create.passed', [$not->data['teacher_id'],$not->data['id']]) }}"
                                            class="list-group-item" >
                                            <div class="media">
                                                <div class="pull-left p-r-10">
                                                <em class="fa fa-bell-o noti-custom"></em>
                                                </div>
                                                <div class="media-body" style="color:blue;">
                                                    <h5 class="media-heading">تم إسناد اختبار في القسم</h5>
                                                    <p class="m-0">
                                                        <small>{{ $main->title }}<b> في المستوي
                                                            </b>{{ $level->title }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                                @foreach (auth('admin')->user()->ReadNotifications as $not)
                                    @if ($not->type == 'App\Notifications\passTest')
                                        @php
                                            $main = \App\Models\Category::where('id', $not->data['main_cat'])->first();
                                            $level = \App\Models\Category::where('id', $not->data['level'])->first();
                                        @endphp

                                        {{-- uread notification --}}
                                        <a href="{{ route('teacher.create.passed', [$not->data['teacher_id'],$not->data['id']]) }}"
                                            class="list-group-item" style="background-color:#eee; ">
                                            <div class="media">
                                                <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-success"></em>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading">تم إسناد اختبار في القسم</h5>
                                                    <p class="m-0">
                                                        <small>{{ $main->title }}<b> في المستوي
                                                            </b>{{ $level->title }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                            </a>
                                    @endif
                                @endforeach
                                @foreach (auth('admin')->user()->unReadNotifications as $not)
                                    @if ($not->type == 'App\Notifications\PassContest')
                                        @php
                                            $main = \App\Models\Category::where('id', $not->data['main_cat'])->first();
                                            $level = \App\Models\Category::where('id', $not->data['level'])->first();
                                        @endphp

                                        {{-- uread notification --}}
                                        <a href="{{ route('teacher.create.passed', [$not->data['teacher_id'],$not->data['id']]) }}"
                                            class="list-group-item" >
                                            <div class="media">
                                                <div class="pull-left p-r-10">
                                                <em class="fa fa-bell-o noti-custom"></em>
                                                </div>
                                                <div class="media-body" style="color:blue;">
                                                    <h5 class="media-heading">تم إسناد مسابقة في القسم</h5>
                                                    <p class="m-0">
                                                        <small>{{ $main->title }}<b> في المستوي
                                                            </b>{{ $level->title }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                                @foreach (auth('admin')->user()->ReadNotifications as $not)
                                    @if ($not->type == 'App\Notifications\PassContest')
                                        @php
                                            $main = \App\Models\Category::where('id', $not->data['main_cat'])->first();
                                            $level = \App\Models\Category::where('id', $not->data['level'])->first();
                                        @endphp

                                        {{-- uread notification --}}
                                        <a href="{{ route('teacher.create.passed', [$not->data['teacher_id'],$not->data['id']]) }}"
                                            class="list-group-item" style="background-color:#eee; ">
                                            <div class="media">
                                                <div class="pull-left p-r-10">
                                                    <em class="fa fa-diamond noti-success"></em>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="media-heading">تم إسناد مسابقة في القسم</h5>
                                                    <p class="m-0">
                                                        <small>{{ $main->title }}<b> في المستوي
                                                            </b>{{ $level->title }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                            </a>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i
                                class="icon-size-fullscreen"></i></a>
                    </li>
                    <li class="dropdown top-menu-item-xs">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown"
                            aria-expanded="true"><img
                                src="{{ asset(auth('admin')->user()->image ?? 'dashboard/images/users/person.png') }}"
                                alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('admin.edit.user',auth('admin')->user()->id)}}"><span class="text-center"
                                        style="color: blue"> {{ auth('admin')->user()->name }}</span></a></li>
                            <li><a href="{{route('admin.edit.user',auth('admin')->user()->id)}}"><i
                                        class="ti-settings m-r-10 text-custom"></i> @lang('lang.profile')</a></li>
                            <li><a href="{{route('admin.logout')}}"><i class="ti-power-off m-r-10 text-danger"></i>
                                    @lang('lang.Logout')</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!--/.nav-collapse -->

<!-- Top Bar End -->

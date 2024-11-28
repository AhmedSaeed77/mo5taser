<div class="container">
    <div class="row">
        <!-- Col -->
        <div class="col-md-12">
            <div class="search-h">
                <h1>@lang('lang.start_with_mo5tasr')</h1>
                <form action="{{route('search')}}" method="GET">
                    @method('GET')
                    <div class="form-group">
                        <button type="button" class="btn-drop">
                            <!--<option selected disabled>@lang('lang.choose_course')</option>-->
                            <span>@lang('lang.choose_course')</span>
                        </button>
                        <div class="sub-drop">
                            <ul>
                                @php
                                    $courses = \App\Models\Course::get();
                                @endphp
                                    @if ($courses->count() > 0)
                                    @foreach ($courses as $course)
                                        <li>
                                            <a href="{{route('course.show',$course->id)}}">
                                                {{$course->title}}
                                            </a>
                                        </li>
                                    
                                    <!--<a href="{{route('course.show',$course->id)}}">
                                        <option value="{{$course->id}}">{{$course->title}}</option>
                                    </a>-->
                                 @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <i class="la la-search"></i>
                        <input type="search" name="search" value="{{request()->search ?? ''}}" placeholder="@lang('lang.search_in_courses')" required/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-form">
                            <span>@lang('lang.search')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Col -->
    </div>
</div>

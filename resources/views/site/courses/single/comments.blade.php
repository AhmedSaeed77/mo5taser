

        @if ($comments->count() > 0)
            @foreach ($comments as $comment)
                <div class="single-comment">
                    <div class="person">
                        <img src="{{asset($comment->user->image)}}" alt="img">
                        <span class="name">{{$comment->user->name}}</span>
                    </div>
                    <div class="text">
                        <p>{{$comment->comment}}</p>
                    </div>
                    <div class="control">
                        <button class="replaies-btn">
                            <span>{{$comment->childs->count()}}</span>
                            <span>@lang('lang.replies')</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="replaies-comments" {{--style="display: none;"--}}>
                        <div class="comment_replies">
                            @if($comment->childs->count() > 0)
                                @foreach ($comment->childs as $item)
                                    <div class="comment-replay">
                                        <div class="person">
                                            @if($item->user)
                                            <img src="{{asset($item->user->image)}}" alt="img">
                                            @endif
                                            @if($item->teacher)
                                            <img src="{{ asset($item->teacher->image ?? 'dashboard/images/users/person.png') }}" alt="img">
                                            @endif

                                            @if($item->user)
                                            <span class="name">{{$item->user->name}} </span>
                                            @endif
                                            @if($item->teacher)
                                            <span class="name">{{$item->teacher->name}} </span>
                                            @endif
                                        </div>
                                        <div class="text">
                                            <p>{{$item->comment}}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            @endif
                        </div>
                        <form action="#" class="comment-in" method="post">
                            <textarea class="form-control comment_area_reply"  placeholder="@lang('lang.comment')" name="comment" required=""></textarea>
                            <button type="button" class="main-btn btn_comment_reply main border-0" data-content="{{$comment->id}}">@lang('lang.add_comment')</button>
                        </form>
                    </div>
                </div>
                <hr>
            @endforeach
        @endif

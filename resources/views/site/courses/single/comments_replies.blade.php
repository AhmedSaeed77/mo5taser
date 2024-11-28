
@if($comments->count() > 0)
    @foreach ($comments as $item)
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



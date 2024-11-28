<table>
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">@lang('lang.name')</th>
        <th class="text-center">@lang('lang.email')</th>
        <th class="text-center">@lang('lang.whatsapp')</th>
        <th class="text-center">@lang('lang.user_type')</th>
        <th class="text-center">@lang('lang.activation')</th>
    </tr>
    </thead>
    <tbody>
        @if ($users->count() > 0)
            @foreach ($users as $key => $user)
                <tr>
                    <td class="text-center">{{$key + 1}}</td>
                    <td class="text-center">{{$user->name}}</td>
                    <td class="text-center">{{$user->email}}</td>
                    <td class="text-center">{{$user->whatsapp}}</td>
                    <td class="text-center">{{$user->type}}</td>
                    <td class="text-center">{{$user->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

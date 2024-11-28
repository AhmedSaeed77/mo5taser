<thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">@lang('lang.course')</th>
        <th class="text-center">@lang('lang.user')</th>
        <th class="text-center">@lang('lang.phone')</th>
        <th class="text-center">@lang('lang.email')</th>
        <th class="text-center">@lang('lang.coupon')</th>
        <th class="text-center">@lang('lang.difference')</th>
        <th class="text-center">@lang('lang.account_holder_name')</th>
        <th class="text-center">@lang('lang.bank_name')</th>
        <th class="text-center">@lang('lang.transfer_date')</th>
        <th class="text-center">@lang('lang.total')</th>
        <th class="text-center">@lang('lang.activation')</th>
    </tr>
    </thead>
    <tbody>
        @if ($subscribes->count() > 0)
            @foreach ($subscribes as $key => $subscribe)
                <tr>
                    <td class="text-center">{{$key + 1}}</td>
                    <td class="text-center">{{ $subscribe->course->{'title_'.app()->getLocale()} }}</td>
                    <td class="text-center">{{$subscribe->user->name}}</td>
                    <td class="text-center">{{$subscribe->user->phone}}</td>
                    <td class="text-center">{{$subscribe->user->email}}</td>
                    <td class="text-center">{{$subscribe->coupon}}</td>
                    <td class="text-center">{{$subscribe->difference}}</td>
                    <td class="text-center">{{$subscribe->user_account_name}}</td>
                    <td class="text-center">{{$subscribe->bank_name}}</td>
                    <td class="text-center">{{$subscribe->transfer_date}}</td>
                    <td class="text-center">{{$subscribe->total}}</td>
                    <td class="text-center">{{$subscribe->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>

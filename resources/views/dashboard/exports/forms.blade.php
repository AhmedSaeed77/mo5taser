<thead>
<tr>
    <th class="text-center">#</th>
    <th class="text-center">@lang('lang.name')</th>
    <th class="text-center">@lang('lang.email')</th>
    <th class="text-center">@lang('lang.whatsapp')</th>
    <th class="text-center">@lang('lang.bank_transfer_to')</th>
    <th class="text-center">@lang('lang.Transferred bank')</th>
    <th class="text-center">@lang('lang.account_owner_phone')</th>
    <th class="text-center">@lang('lang.course_name')</th>
    <th class="text-center">@lang('lang.price')</th>
    <th class="text-center">@lang('lang.entity')</th>
    <th class="text-center">@lang('lang.notes')</th>
    <th class="text-center">@lang('lang.heard_about')</th>
</tr>
</thead>
<tbody>
    @if ($forms->count() > 0)
        @foreach ($forms as $key => $form)
            <tr>
                <td class="text-center">{{$key + 1}}</td>
                <td class="text-center">{{$form->name}}</td>
                <td class="text-center">{{$form->email}}</td>
                <td class="text-center">{{$form->whatsapp}}</td>
                <td class="text-center">{{$form->bank_name_to}}</td>
                <td class="text-center">{{$form->bank_name_from}}</td>
                <td class="text-center">{{$form->account_owner_phone}}</td>
                <td class="text-center">{{$form->course_name}}</td>
                <td class="text-center">{{$form->price}}</td>
                <td class="text-center">{{$form->entity}}</td>
                <td class="text-center">{{$form->notes}}</td>
                <td class="text-center">{{$form->heard_about}}</td>
            </tr>
        @endforeach
    @endif
</tbody>

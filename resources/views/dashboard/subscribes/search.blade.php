<table id="datatable-fixed-header" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">@lang('lang.course')</th>
        <th class="text-center">@lang('lang.user')</th>
        <th class="text-center">@lang('lang.whatsapp')</th>
        <th class="text-center">@lang('lang.image')</th>
        <th class="text-center">@lang('lang.total')</th>
        <th class="text-center">@lang('lang.activation')</th>
        <th class="text-center">@lang('lang.created_at')</th>
        <th class="text-center">@lang('lang.control')</th>
    </tr>
    </thead>
    <tbody>
        @if ($subscribes->count() > 0)
            @foreach ($subscribes as $key => $subscribe)
                <tr>
                    <td class="text-center">{{$key + 1}}</td>
                    <td class="text-center">{{$subscribe->course->title}}</td>
                    <td class="text-center">
                        <a href="{{route('users.edit' ,$subscribe->user->id )}}" target="_blank">
                            {{$subscribe->user->name}}
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="https://wa.me/{{$subscribe->user->whatsapp}}" target="_blank">
                            {{$subscribe->user->whatsapp}}
                        </a>
                    </td>
                    <td class="text-center"><img src="{{asset($subscribe->image)}}" style="width: 80px; height: 80px; border-radius: 50%"></td>
                    <td class="text-center">{{$subscribe->total}}</td>
                    <td class="text-center">{{$subscribe->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                    <td class="text-center">{{$subscribe->created_at->format('Y-m-d H:i')}}</td>
                    <td class="text-center">
                        @if(auth()->user()->hasPermissionTo('courses_update'))
                        <a href="{{route('subscribes.edit' ,$subscribe->id )}}">
                            <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                        </a>
                        @endif

                        @if(auth()->user()->hasPermissionTo('courses_delete'))

                        <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                        data-id="{{$subscribe->id}}"> @lang('lang.delete') </button>

                        <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                    </div>
                                    <form action="{{route('subscribes.destroy',$subscribe->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
                                        @csrf
                                        @method('DELETE')
                                            <div class="modal-body text-center">
                                                <div class="alert alert-danger">
                                                   <h3>@lang('lang.confirm_delete')</h3>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal"> @lang('lang.close') </button>
                                                <button type="submit" class="btn btn-danger pull-right"> @lang('lang.delete') </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach

        @endif
    </tbody>
</table>
<div>
    @if ($subscribes->count() > 0)
    {{$subscribes->links()}}
    @endif
</div>

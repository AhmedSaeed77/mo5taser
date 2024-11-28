@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.exchanges')</b></h4>
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.user')</th>
                                            <th class="text-center">@lang('lang.phone')</th>
                                            <th class="text-center">@lang('lang.image_transfer')</th>
                                            <th class="text-center">@lang('lang.amount')</th>
                                            <th class="text-center">@lang('lang.all balance')</th>
                                            <th class="text-center">@lang('lang.status')</th>
                                            <th class="text-center">@lang('lang.paid')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($exchanges->count() > 0)
                                                @foreach ($exchanges as $key => $exchange)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$exchange->user->name}}</td>
                                                        <td class="text-center">{{$exchange->user->phone}}</td>
                                                        <td class="text-center">
                                                            @if($exchange->image_transfer)
                                                            <img src="{{asset($exchange->image_transfer)}}" style="width: 80px; height: 80px; border-radius: 50%">
                                                            @else
                                                                ----
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{$exchange->amount}}  @lang('lang.rs')</td>
                                                        <td class="text-center">{{$exchange->user->balance}} @lang('lang.rs')</td>
                                                        <td class="text-center">{{__('lang.'.$exchange->status)}}</td>
                                                        <td class="text-center">{{$exchange->paid == 1 ? __('lang.paid') : __('lang.unpaid')}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('exchange.edit' ,$exchange->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            data-id="{{$exchange->id}}"> @lang('lang.delete') </button>

                                                            {{--  modal  --}}
                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('exchange.destroy' ,$exchange->id )}}" method="POST" enctype="multipart/form-data" id="userForm">
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

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>

@endsection

@section('js')
    @include('dashboard.includes.datatable_js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
        });
    </script>

@endsection


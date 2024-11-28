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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.privacies')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <a href="{{route('privacy.create')}}">
                                            <button class="btn btn-success waves-effect waves-light">@lang('lang.create')</button>
                                        </a>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title_ar')</th>
                                            <th class="text-center">@lang('lang.title_en')</th>
                                            <th class="text-center">@lang('lang.content_ar')</th>
                                            <th class="text-center">@lang('lang.content_en')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($privacies->count() > 0)
                                                @foreach ($privacies as $key => $privacy)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{$privacy->title_ar}}</td>
                                                        <td class="text-center">{{$privacy->title_en}}</td>
                                                        <td class="text-center">
                                                            {!! \Illuminate\Support\Str::limit($privacy->content_ar, 50, '') !!}
                                                        </td>
                                                        <td class="text-center">
                                                            {!! \Illuminate\Support\Str::limit($privacy->content_en, 50, '') !!}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('privacy.edit' ,$privacy->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$privacy->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('privacy.destroy',$privacy->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
    <script src="{{asset('ckeditor/ckeditor.js') }}"></script>

    <script>
            CKEDITOR.replace('markdownckeditor');
    </script>
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


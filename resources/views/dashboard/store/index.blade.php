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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.store')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title_ar')</th>
                                            <th class="text-center">@lang('lang.title_en')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($products->count() > 0)
                                                @foreach ($products as $key => $product)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$product->title_ar}}</td>
                                                        <td class="text-center">{{$product->title_en}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('store.edit' ,$product->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <button class="btn btn-danger " alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$product->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('store.destroy',$product->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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

    {{--  modal  --}}
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('lang.create')</h4>
                </div>
                <form action="{{ route('store.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="type" type="hidden" value="book">
                    <input name="show_flag" type="hidden" value="store">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 2px;">
                                    <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                    <input type="text" class="form-control" id="field-1" name="title_ar"
                                    placeholder="@lang('lang.title_ar')" required value="{{ old('title_ar') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 2px;">
                                    <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                    <input type="text" class="form-control" id="field-1" name="title_en"
                                    placeholder="@lang('lang.title_en')" required value="{{ old('title_en') }}">
                                </div>
                            </div>
                            {{--
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 2px;">
                                    <label for="field-1" class="control-label">@lang('lang.belongsTo')</label>
                                    <select class="form-control" required name="category_id[]" id="child_cat">
                                        <option value="">@lang('lang.choose')</option>
                                    </select>
                                </div>
                            </div>  --}}
                            <div class="col-md-6">
                                <div class="form-group no-margin" style="margin: 2px;">
                                    <label for="field-7" class="control-label">@lang('lang.content_ar')</label>
                                    <textarea class="form-control autogrow" id="field-7" name="content_ar"
                                    placeholder="@lang('lang.content_ar')" required
                                    style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_ar') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group no-margin" style="margin: 2px;">
                                    <label for="field-7" class="control-label">@lang('lang.content_en')</label>
                                    <textarea class="form-control autogrow" id="field-7" name="content_en"
                                    placeholder="@lang('lang.content_en')" required
                                    style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_en') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group no-margin" style="margin: 2px;">
                                    <label for="field-7" class="control-label">@lang('lang.image')</label>
                                    <input type="file" class="form-control" name="image" accept="image/*" required>
                                </div>
                            </div>
                            <div class="row">
                                <div id="book">
                                    <div class="col-md-6">
                                        <div class="form-group no-margin" style="margin: 2px;">
                                            <label for="field-7" class="control-label">@lang('lang.book_preview')</label>
                                            <input type="file" class="form-control" id="book_preview" name="book_preview" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group no-margin" style="margin: 2px;">
                                            <label for="field-7" class="control-label">@lang('lang.book')</label>
                                            <input type="file" class="form-control" id="book" name="book" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin: 2px;">
                                            <label for="field-1" class="control-label">@lang('lang.price')</label>
                                            <input type="number" min="1" class="form-control" id="field-1" name="price"
                                            placeholder="@lang('lang.price')" id="price" value="{{ old('price') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('lang.close')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="lang" value="{{Config::get('app.locale')}}">



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
    <script>
        $(document).ready(function(){
            // get levels related with department

            {{--  $('#parent_cat').on('change',function(e) {
                var department_id = e.target.value;
                var lang = $("#lang").val();
                $.ajax({
                      url:"{{ route('get_childs') }}",
                      type:"POST",
                      data: {
                           department_id: department_id,
                           _token: '{!! csrf_token() !!}',
                       },
                      success:function (data) {
                           $('#child_cat').empty();

                           if(data.length == 0){
                               $('#child_cat').append('<option value="">'+"@lang('lang.not_found_level')"+'</option>');
                           }
                           else{

                             $.each(data,function(index,level){
                                 if(lang == 'ar')
                                 {
                                   $('#child_cat').append('<option value="'+level.id+'">'+level.title_ar+'</option>');
                                 }
                                 if(lang == 'en')
                                 {
                                   $('#child_cat').append('<option value="'+level.id+'">'+level.title_en+'</option>');
                                 }

                               })
                           }

                      }
                })
            });  --}}

        });
    </script>

@endsection




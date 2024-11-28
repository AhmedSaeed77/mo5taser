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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.assemblies')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title_ar')</th>
                                            <th class="text-center">@lang('lang.title_en')</th>
                                            <th class="text-center">@lang('lang.type')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($assemblies->count() > 0)
                                                @foreach ($assemblies as $key => $assemble)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$assemble->title_ar}}</td>
                                                        <td class="text-center">{{$assemble->title_en}}</td>
                                                        <td class="text-center">{{$assemble->type == 'book' ? __('lang.book') : __('lang.video')}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('assemble.edit' ,$assemble->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <button class="btn btn-danger " alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$assemble->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('assemble.destroy',$assemble->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                <form action="{{ route('assemble.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="show_flag" type="hidden" value="assemble">
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
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 2px;">
                                    <label for="field-1" class="control-label">@lang('lang.category')</label>
                                    <select class="form-control" required name="category_id">
                                        <option value="">@lang('lang.choose')</option>
                                        @if($categories->count() > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 2px;">
                                    <label for="field-1" class="control-label">@lang('lang.type')</label>
                                    <select class="form-control" required name="type" id="type">
                                        <option value="">@lang('lang.choose')</option>
                                        <option value="book">@lang('lang.book')</option>
                                        <option value="video">@lang('lang.video')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div id="video" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('lang.video platform')</label>
                                            <select class="form-control" name="video_platform">
                                                <option {{ old('preview_video_platform') == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                                <option {{ old('preview_video_platform') == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="margin: 2px;">
                                            <label for="field-1" class="control-label">@lang('lang.link')</label>
                                            <input type="text" class="form-control" id="field-1" name="link" id="link"
                                            placeholder="@lang('lang.link')" value="{{ old('link') }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="book" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group no-margin" style="margin: 2px;">
                                            <label for="field-7" class="control-label">@lang('lang.book_preview') <span style="color: red">@lang('lang.optional')</span></label>
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
                                            <label for="field-1" class="control-label">@lang('lang.price') <span style="color: red">@lang('lang.optional')</span></label>
                                            <input type="number" min="0" class="form-control" id="field-1" name="price"
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


            $('#type').on('change',function(e) {
                var type = e.target.value;

                if(type == 'video')
                {
                    $('#video').css('display','block');
                    $('#book').css('display','none');
                    $("#book_preview").prop('required',false);
                    $("#book").prop('required',false);
                    $("#price").prop('required',false);
                    $("#link").prop('required',true);

                }
                else
                {
                    $('#video').css('display','none');
                    $('#book').css('display','block');
                    $("#book_preview").prop('required',false);
                    $("#book").prop('required',true);
                    $("#price").prop('required',true);
                    $("#link").prop('required',false);
                }
            });
        });
    </script>

@endsection




@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')

@section('css')
<link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
    type="text/css" />

@endsection

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
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>@lang('lang.assemblies') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('assemble.update',$assemble) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input name="show_flag" type="hidden" value="assemble">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                                            <input type="text" class="form-control" id="field-1" name="title_ar"
                                                            placeholder="@lang('lang.title_ar')" required value="{{ $assemble->title_ar }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                                            <input type="text" class="form-control" id="field-1" name="title_en"
                                                            placeholder="@lang('lang.title_en')" required value="{{ $assemble->title_en }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.category')</label>
                                                            <select class="form-control" required name="category_id">
                                                                <option value="">@lang('lang.choose')</option>
                                                                @if($categories->count() > 0)
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{$category->id}}" {{$assemble->category_id == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
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
                                                                @if($childs->count() > 0)
                                                                    @foreach ($childs as $child)
                                                                        <option value="{{$child->id}}" {{$assemble->category_id == $child->id ? 'selected' : ''}}>{{$child->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>  --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group no-margin" style="margin: 2px;">
                                                            <label for="field-7" class="control-label">@lang('lang.content_ar')</label>
                                                            <textarea class="form-control autogrow" id="field-7" name="content_ar"
                                                            placeholder="@lang('lang.content_ar')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ $assemble->content_ar }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group no-margin" style="margin: 2px;">
                                                            <label for="field-7" class="control-label">@lang('lang.content_en')</label>
                                                            <textarea class="form-control autogrow" id="field-7" name="content_en"
                                                            placeholder="@lang('lang.content_en')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ $assemble->content_en }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group no-margin" style="margin: 2px;">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($assemble->image)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group" style="margin: 2px;width: 50%">
                                                            <label for="field-1" class="control-label">@lang('lang.type')</label>
                                                            <select class="form-control" required name="type" id="type">
                                                                <option value="">@lang('lang.choose')</option>
                                                                <option value="book" {{$assemble->type == 'book' ? 'selected' : ''}}>@lang('lang.book')</option>
                                                                <option value="video" {{$assemble->type == 'video' ? 'selected' : ''}}>@lang('lang.video')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="video" style="display: {{$assemble->type == 'video' ? 'block' : 'none'}}">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('lang.video platform')</label>
                                                                    <select class="form-control" name="video_platform">
                                                                        <option {{ $assemble->video_platform == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                                                        <option {{ $assemble->video_platform == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group" style="margin: 2px;">
                                                                    <label for="field-1" class="control-label">@lang('lang.link')</label>
                                                                    <input type="text" class="form-control" id="field-1" name="link" id="link"
                                                                    placeholder="@lang('lang.link')" value="{{$assemble->link }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="book" style="display: {{$assemble->type == 'book' ? 'block' : 'none'}}">
                                                            <div class="col-md-6">
                                                                <div class="form-group no-margin" style="margin: 2px;">
                                                                    <label for="field-7" class="control-label">@lang('lang.book_preview') <span style="color: red">@lang('lang.optional')</span></label>
                                                                    <input type="file" class="form-control" id="book_preview" name="book_preview" >
                                                                    @if($assemble->book_preview)
                                                                        <span style="color: red">@lang('lang.optional')</span>
                                                                        <br>
                                                                        <a href="{{asset($assemble->book_preview)}}" target="_blank">@lang('lang.show')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group no-margin" style="margin: 2px;">
                                                                    <label for="field-7" class="control-label">@lang('lang.book')</label>
                                                                    <input type="file" class="form-control" id="book" name="book" >
                                                                    @if($assemble->book)
                                                                        <span style="color: red">@lang('lang.optional')</span>
                                                                        <br>
                                                                        <a href="{{asset($assemble->book)}}" target="_blank">@lang('lang.show')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="margin: 2px;">
                                                                    <label for="field-1" class="control-label">@lang('lang.price') <span style="color: red">@lang('lang.optional')</span></label>
                                                                    <input type="number" min="0" class="form-control" id="field-1" name="price"
                                                                    placeholder="@lang('lang.price')" id="price" value="{{ $assemble->price }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer pull-right">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.edit')</button>
                                            </div>
                                        </form>
                                    </div>
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
                console.log(type)
                if(type == 'video')
                {
                    $('#video').css('display','block');
                    $('#book').css('display','none');

                }
                else
                {
                    $('#video').css('display','none');
                    $('#book').css('display','block');
                }
            });
        });
    </script>
@endsection

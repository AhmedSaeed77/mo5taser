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
                                                <h4>@lang('lang.store') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('store.update',$product) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input name="type" type="hidden" value="book">
                                            <input name="show_flag" type="hidden" value="store">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                                            <input type="text" class="form-control" id="field-1" name="title_ar"
                                                            placeholder="@lang('lang.title_ar')" required value="{{ $product->title_ar }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin: 2px;">
                                                            <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                                            <input type="text" class="form-control" id="field-1" name="title_en"
                                                            placeholder="@lang('lang.title_en')" required value="{{ $product->title_en }}">
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
                                                                        <option value="{{$child->id}}" {{$product->category_id == $child->id ? 'selected' : ''}}>{{$child->title}}</option>
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
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ $product->content_ar }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group no-margin" style="margin: 2px;">
                                                            <label for="field-7" class="control-label">@lang('lang.content_en')</label>
                                                            <textarea class="form-control autogrow" id="field-7" name="content_en"
                                                            placeholder="@lang('lang.content_en')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ $product->content_en }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group no-margin" style="margin: 2px;">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($product->image)}}" style="width: 100px; height: 100px;">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="book">
                                                            <div class="col-md-6">
                                                                <div class="form-group no-margin" style="margin: 2px;">
                                                                    <label for="field-7" class="control-label">@lang('lang.book_preview')</label>
                                                                    <input type="file" class="form-control" id="book_preview" name="book_preview" >
                                                                    @if($product->book_preview)
                                                                        <span style="color: red">@lang('lang.optional')</span>
                                                                        <br>
                                                                        <a href="{{asset($product->book_preview)}}" target="_blank">@lang('lang.show')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group no-margin" style="margin: 2px;">
                                                                    <label for="field-7" class="control-label">@lang('lang.book')</label>
                                                                    <input type="file" class="form-control" id="book" name="book" >
                                                                    @if($product->book)
                                                                        <span style="color: red">@lang('lang.optional')</span>
                                                                        <br>
                                                                        <a href="{{asset($product->book)}}" target="_blank">@lang('lang.show')</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group" style="margin: 2px;">
                                                                    <label for="field-1" class="control-label">@lang('lang.price')</label>
                                                                    <input type="number" min="1" class="form-control" id="field-1" name="price"
                                                                    placeholder="@lang('lang.price')" id="price" value="{{ $product->price }}">
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

        });
    </script>
@endsection

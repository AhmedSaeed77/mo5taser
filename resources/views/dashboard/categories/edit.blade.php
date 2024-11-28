@extends('dashboard.includes.app')
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
                                                <h4>@lang('lang.categories_with') -- {{$category->type}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('category.update',$category) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                                            <input type="text" class="form-control" id="field-1"name="title_ar"
                                                            placeholder="@lang('lang.title_ar')" required value="{{$category->title_ar}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                                            <input type="text" class="form-control" id="field-1"name="title_en"
                                                            placeholder="@lang('lang.title_en')" required value="{{$category->title_en}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($category->type != 'assemblies')
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.type')</label>
                                                            <select class="form-control" name="parent_id">
                                                                <option value="">@lang('lang.parent_cat')</option>
                                                                @if($main_categories->count() > 0)
                                                                    @foreach ($main_categories as $item)
                                                                        @if($item->id != $category->id)
                                                                            <option value="{{$item->id}}" {{$category->parent_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.belongsTo')</label>
                                                            <select class="form-control" name="type" required>
                                                                <option value="{{$category->type}}" selected>{{$category->type}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" name="image" accept="image/*">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                            <br>
                                                            <img class="img-thumbnail" src="{{asset($category->image)}}" onerror="this.src='https://via.placeholder.com/150'" style="width: 100px; height: 100px;">
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

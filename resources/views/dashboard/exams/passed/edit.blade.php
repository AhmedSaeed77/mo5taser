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
                                                <h4>@lang('lang.passed_exam')</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('pass.update',$pass) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.questions_number')</label>
                                                            <input type="number" min="1" class="form-control" id="field-1"name="questions_number"
                                                            placeholder="@lang('lang.questions_number')" required value="{{ $pass->questions_number}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.exam_time')</label>
                                                            <input type="number" min="1" class="form-control" id="field-1"name="exam_time"
                                                            placeholder="@lang('lang.exam_time')" value="{{ $pass->exam_time}}">
                                                            <span style="color: red">@lang('lang.optional')</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.attemps')</label>
                                                            <input type="number" min="1" class="form-control" id="field-1"name="attemps"
                                                            placeholder="@lang('lang.attemps')" value="{{ $pass->attemps}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.teacher')</label>
                                                            <select class="form-control" name="teacher_id" required>
                                                                <option value="">@lang('lang.choose')</option>
                                                                @if($teachers->count() > 0)
                                                                    @foreach ($teachers as $item)
                                                                        <option value="{{$item->id}}" {{$item->id == $pass->teacher_id ? 'selected' : ''}}>{{$item->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.main_cat')</label>
                                                            <select class="form-control" name="main_cat" required id="department">
                                                                <option value="">@lang('lang.choose')</option>
                                                                @if($main_categories->count() > 0)
                                                                    @foreach ($main_categories as $item_cat)
                                                                        <option value="{{$item_cat->id}}" {{$item_cat->id == $pass->main_cat ? 'selected' : ''}}>{{$item_cat->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.level')</label>
                                                            <select class="form-control" name="level" id="level" required>
                                                                   <option value="{{$pass->levelCat->id}}">{{$pass->levelCat->title}}</option>
                                                                @if($levels->count() > 0)
                                                                    @foreach ($levels as $level)
                                                                        <option value="{{$level->id}}">{{$level->title}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
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

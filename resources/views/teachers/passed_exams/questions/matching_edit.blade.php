{{--  matching question  --}}
<div class="row">
    <form action="{{route('questions.update',$question)}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_matching">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 matching_section">
                    <div class="form-group no-margin">
                        <div class="text-end">
                            <button type="button" id="add_btn" class="btn btn-default waves-effect">@lang('lang.add_question')</button>
                            <button type="button" id="delete_btn" class="btn btn-danger waves-effect waves-light">@lang('lang.remove_question')</button>
                        </div>
                        <div class="row matching_row">
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.questions')</h5>
                                <div class="matching_questions">
                                    @if(sizeOf($questions) > 0)
                                        @for ($i=0; $i < sizeOf($questions); $i++)
                                            @php
                                                $match = (array)($questions[$i]);
                                            @endphp
                                            <div class="form-group" data-num="{{$match['qn']}}">
                                                <span class="num">{{$match['qn']}}</span>
                                                <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="{{$match['qn']}}" value="{{$match['q']}}" required>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.answers')</h5>
                                <div class="matching_answers">
                                    @if(sizeOf($questions) > 0)
                                        @for ($i=0; $i < sizeOf($questions); $i++)
                                            @php
                                                $match = (array)($questions[$i]);
                                            @endphp
                                            <div class="form-group" data-num="{{$match['an']}}">
                                                <input type="hidden" value="{{$match['an']}}">
                                                <span class="num">{{$match['an']}}</span>
                                                <input type="text" class="form-control" placeholder="@lang('lang.answer')" value="{{$match['a']}}" required>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $subject_val = $question->subjectId();
                    $second_childs_subjects = \App\Models\Subject::whereIn('parent_id',$subjects->pluck('id')->toArray())->get();
                    $third_childs_subjects = \App\Models\Subject::whereIn('parent_id',$second_childs_subjects->pluck('id')->toArray())->get();
                @endphp
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control subject_class" name="subject_id[]" required>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}" {{in_array($subject->id,$subject_val) ? 'selected' : ''}}>{{$subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 child_subject1 {{count(array_intersect($subject_val,$second_childs_subjects->pluck('id')->toArray())) > 0 ? '' : 'hidden'}}">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control child_subject1_select1" name="subject_id[]">
                            <option value="">@lang('lang.choose')</option>
                            @if($second_childs_subjects->count() > 0)
                                @foreach ($second_childs_subjects as $second_subject)
                                        <option value="{{$second_subject->id}}" {{in_array($second_subject->id,$subject_val) ? 'selected' : ''}}>{{$second_subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 child_subject2 {{count(array_intersect($subject_val,$third_childs_subjects->pluck('id')->toArray())) > 0 ? '' : 'hidden'}}">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control child_subject1_select2" name="subject_id[]">
                            <option value="">@lang('lang.choose')</option>
                            @if($third_childs_subjects->count() > 0)
                                @foreach ($third_childs_subjects as $third_subject)
                                        <option value="{{$third_subject->id}}" {{in_array($third_subject->id,$subject_val) ? 'selected' : ''}}>{{$third_subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{$question->degree }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change">
                            <span>@lang('lang.image')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <br>
                        @if($question->image)
                          <img class="img-thumbnail" src="{{asset($question->image)}}" style="width: 100px; height: 100px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video platform')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <select class="form-control" name="video_platform">
                            <option {{ $question->video_platform == '' ?  'selected' : ''}} value="">------</option>
                            <option {{ $question->video_platform == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                            <option {{ $question->video_platform == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                        </select>

                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video_url')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <input type="text" class="form-control" id="field-1" name="video_url"
                        placeholder="@lang('lang.video_url')"  value="{{ $question->video_url }}">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change">
                                <span>@lang('lang.hint_image')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <input type="file" class="form-control" name="hint_image" accept="image/*">
                            <br>
                            @if($question->hint_image)
                            <img class="img-thumbnail" src="{{asset($question->hint_image)}}" style="width: 100px; height: 100px;">
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">
                                <span>@lang('lang.hint video platform')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <select class="form-control" name="hint_video_platform">
                                <option {{ $question->hint_video_platform == '' ?  'selected' : ''}} value="">------</option>
                                <option {{ $question->hint_video_platform == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                <option {{ $question->hint_video_platform == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                            </select>

                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">
                                <span>@lang('lang.hint_video')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="hint_video"
                            placeholder="@lang('lang.hint_video')"  value="{{ $question->hint_video }}">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change label-change">
                                <span>@lang('lang.hint')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <textarea class="form-control ckeditor" name="hint" id="ckeditor{{rand(100,10000)}}" required>{!! $question->hint !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="exam_id" value="{{$exam->id}}">
        <input type="hidden" name="type" value="matching">
        <input type="hidden" name="question" id="questions_value" value="">
        <div class="modal-footer">
            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.edit')</button>
        </div>
    </form>
</div>
{{--  matching question  --}}

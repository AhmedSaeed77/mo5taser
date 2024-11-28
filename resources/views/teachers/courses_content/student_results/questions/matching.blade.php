{{--  matching question  --}}
<div class="row">
    <form action="{{route('content_answer.update',$answer)}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_matching">
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
                                    @php
                                        $questions = json_decode($answer->question->question);
                                    @endphp
                                    @if(sizeOf($questions) > 0)
                                        @for ($i=0; $i < sizeOf($questions); $i++)
                                            @php
                                                $match = (array)($questions[$i]);
                                            @endphp
                                            <div class="form-group" data-num="{{$match['qn']}}">
                                                <span class="num">{{$match['qn']}}</span>
                                                <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="{{$match['qn']}}" value="{{$match['q']}}" required readonly>
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
                                                <input type="text" class="form-control" placeholder="@lang('lang.answer')" value="{{$match['a']}}" required readonly>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control" name="subject_id" disabled>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subjects)
                                        <option value="{{$subjects->id}}" {{$answer->question->subject_id == $subjects->id ? 'selected' : ''}}>{{$subjects->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{ $answer->question->degree }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if($answer->question->image)
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change">
                            <span>@lang('lang.image')</span>
                        </label>
                        <br>
                        <img class="img-thumbnail" src="{{asset($answer->question->image)}}" style="width: 100px; height: 100px;">
                    </div>
                </div>
                @endif
                @if($answer->question->video_url)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video_url')</span>
                        </label>
                        <input type="text" class="form-control" id="field-1" name="video_url"
                        placeholder="@lang('lang.video_url')"  value="{{ $answer->question->video_url }}" readonly>

                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change label-change">
                                <span>@lang('lang.hint')</span>
                            </label>
                            <textarea class="form-control" name="hint" id="ckeditor2" required readonly>{!! $answer->question->hint !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12 matching_section">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.student_answer')</label>
                        <div class="row matching_row">
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.questions')</h5>
                                <div class="matching_questions">
                                    @php
                                        $questions = json_decode($answer->student_answer);
                                    @endphp
                                    @if($questions)
                                        @if(sizeOf($questions) > 0)
                                            @for ($i=0; $i < sizeOf($questions); $i++)
                                                @php
                                                    $match = (array)($questions[$i]);
                                                @endphp
                                                <div class="form-group" data-num="{{$match['qn']}}">
                                                    <span class="num">{{$match['qn']}}</span>
                                                    <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="{{$match['qn']}}" value="{{$match['q']}}" required readonly>
                                                </div>
                                            @endfor
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.answers')</h5>
                                <div class="matching_answers">
                                    @if($questions)
                                    @if(sizeOf($questions) > 0)
                                        @for ($i=0; $i < sizeOf($questions); $i++)
                                            @php
                                                $match = (array)($questions[$i]);
                                            @endphp
                                            <div class="form-group" data-num="{{$match['an']}}">
                                                <input type="hidden" value="{{$match['an']}}">
                                                <span class="num">{{$match['an']}}</span>
                                                <input type="text" class="form-control" placeholder="@lang('lang.answer')" value="{{$match['a']}}" required readonly>
                                            </div>
                                        @endfor
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">
                            <span>@lang('lang.answer_type')</span>
                        </label>
                        <select class="form-control" name="type" required>
                            <option value="" >@lang('lang.choose')</option>
                            <option value="0" {{$answer->type == '0' ? 'selected' : ''}}>@lang('lang.wrong_answer')</option>
                            <option value="1" {{$answer->type == '1' ? 'selected' : ''}}>@lang('lang.true_answer')</option>
                            <option value="2" {{$answer->type == '2' ? 'selected' : ''}}>@lang('lang.uncomplete_answer')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">
                            <span>@lang('lang.teacher_degree')</span>
                        </label>
                        <input type="number" min="0" max="{{$answer->question->degree}}" class="form-control" id="field-1" name="teacher_degree"
                        value="{{$answer->teacher_degree}}" placeholder="@lang('lang.teacher_degree')" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.send_answer_degree')</button>
        </div>
    </form>
</div>
{{--  matching question  --}}
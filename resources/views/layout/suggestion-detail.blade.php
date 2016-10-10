@if (count($suggestion->suggestionDetails))
    @foreach ($suggestion->suggestionDetails as $suggestionDetail)
        @if ($type == config('common.question.type_question.text'))
            <div class="row">
                <div class="col-lg-10">
                    {{ Form::textarea('content_option[' . $suggestionDetail->id . ']', $suggestionDetail->option, ['class' => 'form-control', 'rows' => 3,
                    'placeholder' => trans('users/suggestions/names.placeholder.content_option')]) }}
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-danger" onclick="removeSuggestionDetail('{{ $suggestionDetail->id }}')"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>
            <hr>
        @elseif ($type == config('common.question.type_question.multiple_choice'))
            <div class="row">
                <div class="col-lg-7">
                    {{ Form::textarea('content_option[' . $suggestionDetail->id . ']', $suggestionDetail->option, ['class' => 'form-control', 'rows' => 3,
                    'placeholder' => trans('users/suggestions/names.placeholder.content_option')]) }}
                </div>
                <div class="col-lg-3">
                    <label> {{ trans('admins/question_answers/names.label_form.correct_question_answer') }}</label>
                    {{ Form::checkbox('correct_option[' . $suggestionDetail->id . ']',
                    config('common.question_answer.correct.answer_true'), ($suggestionDetail->correct == trans('admins/suggestions/names.label_form.correct.true') ? 'checked' : '')) }}
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-danger" onclick="removeSuggestionDetail('{{ $suggestionDetail->id }}')"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>
            <hr>
        @else
            <div class="row">
                <div class="col-lg-7">
                    {{ Form::textarea('content_option[' . $suggestionDetail->id . ']', $suggestionDetail->option, ['class' => 'form-control', 'rows' => 3,
                    'placeholder' => trans('users/suggestions/names.placeholder.content_option')]) }}
                </div>
                <div class="col-lg-3">
                    <label> {{ trans('admins/question_answers/names.label_form.correct_question_answer') }}</label>
                    {{ Form::radio('correct_option[' . $suggestionDetail->id . ']',
                    config('common.question_answer.correct.answer_true'), ($suggestionDetail->correct == trans('admins/suggestions/names.label_form.correct.true') ? 'checked': '')) }}
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-danger" onclick="removeSuggestionDetail('{{ $suggestionDetail->id }}')"><span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>
            <hr>
        @endif
    @endforeach
@endif

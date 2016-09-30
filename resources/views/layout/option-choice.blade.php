<div class="row option" id = "idOption">
    <div class="col-lg-9">
        {{ Form::textarea('contentName', null, ['class' => 'form-control', 'rows' => 2,
        'placeholder' => trans('admins/question_answers/names.placeholder.content_question_answer')]) }}
    </div>
    <div class="col-lg-2 radio-correct">
        {{ Form::radio('correctName', config('common.question_answer.correct.answer_true')) }}
        {{ Form::label(trans('names.label.label_for', ['label_for' => 'true']), trans('admins/question_answers/names.label_form.question_answer_true')) }}
        {{ Form::radio('correctName', config('common.question_answer.correct.answer_false'), true) }}
        {{ Form::label(trans('names.label.label_for', ['label_for' => 'false']), trans('admins/question_answers/names.label_form.question_answer_false')) }}
    </div>
    <div class="col-lg-1">
        <button type="button" class="btn btn-danger" onclick="removeOption('idOption')"><i class="fa fa-trash"></i></button>
    </div>
</div>

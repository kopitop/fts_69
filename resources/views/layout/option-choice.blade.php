<div class="row option" id = "idOption">
    <div class="col-lg-9">
        <label for="{{ trans('names.label.label_for', ['label_for' => 'content_question_answer']) }}">
            {{ trans('admins/question_answers/names.label_form.content_question_answer') . trans('names.label.label_require') }}
        </label>
        <textarea class="form-control" rows="2" name="contentName"
                  placeholder="{{ trans('admins/question_answers/names.placeholder.content_question_answer') }}">contentValue</textarea>
    </div>
    <div class="col-lg-2 radio-correct">
        <label class="radio-inline" for="{{ trans('names.label.label_for', ['label_for' => 'true']) }}">
            <input type="radio" name="correctName" value="{{ config('common.question_answer.correct.answer_true') }}"
                   id="true-idOption">
            {{ trans('admins/question_answers/names.label_form.question_answer_true') }}
        </label>
        <label class="radio-inline" for="{{ trans('names.label.label_for', ['label_for' => 'false']) }}">
            <input type="radio" name="correctName" value="{{ config('common.question_answer.correct.answer_false') }}"
                   id="false-idOption">
            {{ trans('admins/question_answers/names.label_form.question_answer_false') }}
        </label>
    </div>
    <div class="col-lg-1">
        <button type="button" class="btn btn-danger" onclick="removeOption('idOption')">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>

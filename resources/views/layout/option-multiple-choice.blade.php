<div class="option" id = "idOption">
    <label for="option text">
        {{ trans('users/suggestions/names.label.option') . trans('names.label.label_require') }}
    </label>
    <div class="alert alert-success">
        <div class="row">
            <div class="col-lg-6">
                <textarea name="content_multiple_choice[idOption]" class="form-control" rows="5"
                          placeholder="{{ trans('users/suggestions/names.placeholder.content_option') }}"></textarea>
            </div>
            <div class="col-lg-3">
                <label><input type="checkbox" name="correct_multiple_choice[idOption]"
                              value="{{ config('common.question_answer.correct.answer_true') }}" >
                    {{ trans('users/suggestions/names.label.answer_true') }}
                </label>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-danger" onclick="removeOption('idOption')">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </div>
        </div>
    </div>
    <hr>
</div>

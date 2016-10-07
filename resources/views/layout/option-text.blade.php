<div class="option" id = "idOption">
    <label for="option text">
        {{ trans('users/suggestions/names.label.option') . trans('names.label.label_require') }}
    </label>
    <div class="alert alert-info">
        <div class="row">
            <div class="col-lg-9">
                <textarea name="content_text[idOption]" class="form-control" rows="5"
                          placeholder="{{ trans('users/suggestions/names.placeholder.content_option') }}"></textarea>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-danger" onclick="removeOption('idOption')">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </div>
        </div>
    </div>
    <hr>
</div>


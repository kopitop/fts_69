@extends('admins.master')
@section('title')
    {{ trans('admins/question_answers/names.title_question_answer_page') }}
@endsection
@section('heading')
    {{ trans('admins/question_answers/names.heading_question_answer_page') }}
@endsection
@section('action')
    {{ trans('admins/question_answers/names.action.edit_question_answer') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/question_answers/names.panel.panel_head_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => ['admin.question-answer.update', $questionAnswer->id], 'method' => 'PUT']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'question']),
                    trans('admins/question_answers/names.label_form.question_of_answer') . trans('names.label.label_require')) }}
                    {{ Form::select('question_id', $questions, $questionAnswer->question->id,
                    ['class' => 'form-control question-name', 'placeholder' => trans('admins/question_answers/names.placeholder.question_of_answer')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content']),
                    trans('admins/question_answers/names.label_form.content_question_answer') . trans('names.label.label_require')) }}
                    {{
                        Form::textarea(
                            'content',
                            ($questionAnswer->question->type != config('common.question.type_question.text') ? $questionAnswer->content : null),
                            ['class' => 'form-control', 'rows' => 3]
                        )
                    }}
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'correct']),
                    trans('admins/question_answers/names.label_form.correct_question_answer') . trans('names.label.label_require')) }}
                    {{ Form::radio('correct', config('common.question_answer.correct.answer_true'), ($questionAnswer->correct) ? true : "") }}
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'true']), trans('admins/question_answers/names.label_form.question_answer_true')) }}
                    {{ Form::radio('correct', config('common.question_answer.correct.answer_false'), $questionAnswer->correct ? "" : true) }}
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'false']), trans('admins/question_answers/names.label_form.question_answer_false')) }}
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.question-answer.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
            {{
                Form::open([
                    'route' => ['admin.question-answer.destroy', $questionAnswer->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'answer of question']) . '")'
                    ])
            }}
                <i>{{ trans('admins/names.label.label_delete', ['item' => 'answer of question']) }}</i>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/question_answers/names.title_question_answer_page') }}
@endsection
@section('heading')
    {{ trans('admins/question_answers/names.heading_question_answer_page') }}
@endsection
@section('action')
    {{ trans('admins/question_answers/names.action.detail_question_answer') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/question_answers/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <ul>
                <li>
                    <div class="form-group">
                        <label>{{ trans('admins/question_answers/names.label_form.question_of_answer') }}</label>
                        <textarea class="form-control" disabled>{{ $questionAnswer->question->content }}</textarea>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label>{{ trans('admins/question_answers/names.label_form.content_question_answer') }}</label>
                        <textarea class="form-control" disabled>{{ $questionAnswer->content }}</textarea>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label>{{ trans('admins/question_answers/names.label_form.correct_question_answer') }}</label>
                        <input type="text" class="form-control" disabled value="{{
                                $questionAnswer->correct == config('common.question_answer.correct.answer_true')
                                 ? trans('admins/question_answers/names.label_form.question_answer_true')
                                 : trans('admins/question_answers/names.label_form.question_answer_false')
                        }}"/>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.question-answer.destroy', $questionAnswer->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'answer of question']) . '")',
                ])
            }}
                <a href="{{ route('admin.question-answer.edit', ['id' => $questionAnswer->id]) }}" class="btn btn-warning">{{ trans('names.button.button_edit') }}</a>
                <a href="{{ route('admin.question-answer.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection

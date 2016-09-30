@extends('admins.master')
@section('title')
    {{ trans('admins/question_answers/names.title_question_answer_page') }}
@endsection
@section('heading')
    {{ trans('admins/question_answers/names.heading_question_answer_page') }}
@endsection
@section('action')
    {{ trans('admins/question_answers/names.action.add_question_answer') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/question_answers/names.panel.panel_head_add') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            <div class="hide" data-action="create"
                    data-option="{{ $option }}"
                    data-route-option="{{ route('admin.option.store') }}"
                    data-token="{{ csrf_token() }}"
                    data-message="{{ $message }}"
                    data-option-text="{{ $optionText }}">
            </div>
            {{ Form::open(['route' => 'admin.question-answer.store', 'method' => 'POST']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'question']),
                    trans('admins/question_answers/names.label_form.question_of_answer') . trans('names.label.label_require')) }}
                    {{ Form::select('question_id', $questions, null,
                    ['class' => 'form-control question-name', 'placeholder' => trans('admins/question_answers/names.placeholder.question_of_answer')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'question_type']),
                    trans('admins/question_answers/names.label_form.type_question_of_answer')) }}
                    {{ Form::text('type_question', null, ['class' => 'form-control type-question', 'disabled' => true]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content_question_answer']),
                    trans('admins/question_answers/names.label_form.content_question_answer') . trans('names.label.label_require')) }}
                    <div class="answer-content">
                    </div>
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <button type="button" class="btn btn-primary btn-add-option" disabled onclick="addOption()">{{ trans('names.button.button_option') }}</button>
                <a href="{{ route('admin.question-answer.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/questions/names.title_question_page') }}
@endsection
@section('heading')
    {{ trans('admins/questions/names.heading_question_page') }}
@endsection
@section('action')
    {{ trans('admins/questions/names.action.edit_question') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/questions/names.panel.panel_head_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => ['admin.question.update', $question->id], 'method' => 'PUT']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'question']),
                    trans('admins/questions/names.label_form.subject_question') . trans('names.label.label_require')) }}
                    {{ Form::select('subject_id', $data['subjects'], $question->subject->id,
                    ['class' => 'form-control', 'placeholder' => trans('admins/questions/names.placeholder.subject_question')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'type']),
                    trans('admins/questions/names.label_form.type_question') . trans('names.label.label_require')) }}
                    {{ Form::select('type', $data['types'], $question->type,
                    ['class' => 'form-control', 'placeholder' => trans('admins/questions/names.placeholder.type_question')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content_question']),
                    trans('admins/questions/names.label_form.content_question') . trans('names.label.label_require')) }}
                    {{ Form::textarea('content', $question->content, ['class' => 'form-control',
                    'placeholder' => trans('admins/questions/names.placeholder.content_question')]) }}
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.question.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
            {{
                Form::open([
                    'route' => ['admin.question.destroy', $question->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'question']) . '")'
                ])
            }}
                <i>{{ trans('admins/names.label.label_delete', ['item' => 'question']) }}</i>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/subjects/names.title_subject_page') }}
@endsection
@section('heading')
    {{ trans('admins/subjects/names.heading_subject_page') }}
@endsection
@section('action')
    {{ trans('admins/subjects/names.action.edit_subject') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/subjects/names.panel.panel_head_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => ['admin.subject.update', $subject->id], 'method' => 'PUT']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject']),
                    trans('admins/subjects/names.label_form.name_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('name', $subject->name, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.name_subject')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'duration']),
                    trans('admins/subjects/names.label_form.duration_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('duration', $subject->duration, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.duration_subject')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'number_question']),
                    trans('admins/subjects/names.label_form.question_number_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('number_question', $subject->number_question, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.question_number_subject')]) }}
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.subject.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
            {{
                Form::open([
                    'route' => ['admin.subject.destroy', $subject->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'subject']) . '")'
                    ])
            }}
                <i>{{ trans('admins/names.label.label_delete', ['item' => 'subject']) }}</i>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

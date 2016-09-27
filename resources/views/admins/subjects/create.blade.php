@extends('admins.master')
@section('title')
    {{ trans('admins/subjects/names.title_subject_page') }}
@endsection
@section('heading')
    {{ trans('admins/subjects/names.heading_subject_page') }}
@endsection
@section('action')
    {{ trans('admins/subjects/names.action.add_subject') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/subjects/names.panel.panel_head_add') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => 'admin.subject.store', 'method' => 'POST']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject_name']),
                    trans('admins/subjects/names.label_form.name_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('name', null, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.name_subject')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject_duration']),
                    trans('admins/subjects/names.label_form.duration_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('duration', null, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.duration_subject')]) }}
                    <p class="help-block">{{ trans('admins/subjects/names.label_form.help_block_duration') }}</p>
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject_number']),
                    trans('admins/subjects/names.label_form.question_number_subject') . trans('names.label.label_require')) }}
                    {{ Form::text('number_question', null, ['class' => 'form-control',
                    'placeholder' => trans('admins/subjects/names.placeholder.question_number_subject')]) }}
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.subject.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

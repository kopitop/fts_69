@extends('admins.master')
@section('title')
    {{ trans('admins/questions/names.title_question_page') }}
@endsection
@section('heading')
    {{ trans('admins/questions/names.heading_question_page') }}
@endsection
@section('action')
    {{ trans('admins/questions/names.action.add_question') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/questions/names.panel.panel_head_add') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => 'admin.question.store', 'method' => 'POST']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject']),
                    trans('admins/questions/names.label_form.subject_question') . trans('names.label.label_require')) }}
                    {{ Form::select('subject_id', $subjects, null,
                    ['class' => 'form-control', 'placeholder' => trans('admins/questions/names.placeholder.subject_question')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'type']),
                    trans('admins/questions/names.label_form.type_question') . trans('names.label.label_require')) }}
                    {{ Form::select('type', $types, null,
                    ['class' => 'form-control', 'placeholder' => trans('admins/questions/names.placeholder.type_question')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content_question']),
                    trans('admins/questions/names.label_form.content_question') . trans('names.label.label_require')) }}
                    {{ Form::textarea('content', null, ['class' => 'form-control',
                    'placeholder' => trans('admins/questions/names.placeholder.content_question')]) }}
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.question.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

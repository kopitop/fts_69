@extends('master')
@section('title')
    {{ trans('users/suggestions/names.title') }}
@endsection
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">{{ trans('users/suggestions/names.panel_heading_add') }}</div>
        <div class="panel-body">
            <div class="hide" data-action="create"
                 data-option="{{ $data }}">
            </div>
            {{ Form::open(['route' => 'suggestion.store', 'method' => 'POST']) }}
                @include('layout.error')
                @include('layout.message')
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject']),
                    trans('users/suggestions/names.label.subject') . trans('names.label.label_require')) }}
                    {{ Form::select('subject_id', $subjects, null,
                    ['class' => 'form-control', 'placeholder' => trans('users/suggestions/names.placeholder.subject')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'type']),
                    trans('users/suggestions/names.label.type') . trans('names.label.label_require')) }}
                    {{ Form::select('type', $types, null,
                    ['class' => 'form-control type', 'placeholder' => trans('users/suggestions/names.placeholder.type')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content_question']),
                    trans('users/suggestions/names.label.content') . trans('names.label.label_require')) }}
                    {{ Form::textarea('content', null, ['class' => 'form-control',
                    'placeholder' => trans('users/suggestions/names.placeholder.content')]) }}
                </div>
                <div class="form-group option-content">
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('suggestion.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
        </div>
    </div>
    @include('layout.message')
@endsection

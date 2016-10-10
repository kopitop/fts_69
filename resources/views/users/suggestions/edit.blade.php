@extends('master')
@section('title')
    {{ trans('users/suggestions/names.title') }}
@endsection
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">{{ trans('users/suggestions/names.panel-heading_edit') }}</div>
        <div class="panel-body">
            <div class="hide" data-action="edit"
                data-option="{{ $data }}"
                data-suggestion-detail="{{ $suggestionDetail }}"
                data-route="{{ route('suggestion-detail.store') }}"
                data-token="{{ csrf_token() }}">
            </div>
            {{ Form::open(['route' => ['suggestion.update', $suggestion->id], 'method' => 'PUT']) }}
            @include('layout.error')
            @include('layout.message')
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'subject']),
                    trans('users/suggestions/names.label.subject') . trans('names.label.label_require')) }}
                    {{ Form::select('subject_id', $subjects, $suggestion->subject->id,
                    ['class' => 'form-control', 'placeholder' => trans('users/suggestions/names.placeholder.subject')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'type']),
                    trans('users/suggestions/names.label.type') . trans('names.label.label_require')) }}
                    {{ Form::select('type', $types, $type,
                    ['class' => 'form-control type']) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'content_question']),
                    trans('users/suggestions/names.label.content') . trans('names.label.label_require')) }}
                    {{ Form::textarea('content', $suggestion->content, ['class' => 'form-control',
                    'placeholder' => trans('users/suggestions/names.placeholder.content')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'option']),
                    trans('users/suggestions/names.label.option') . trans('names.label.label_require')) }}
                    <button type="button" class="btn btn-primary" onclick="addOption({{ $type }})"><span class="glyphicon glyphicon-plus"></span></button>
                    <hr>
                    <div class="suggestion-detail">
                        @include('layout.suggestion-detail')
                    </div>
                </div>
                <div class="form-group option-content">
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('suggestion.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
            {{
                Form::open([
                    'route' => ['suggestion.destroy', $suggestion->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'suggestion']) . '")'
                ])
            }}
                <i>{{ trans('admins/names.label.label_delete', ['item' => 'suggestion']) }}</i>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection

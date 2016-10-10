@extends('master')
@section('title')
    {{ trans('users/suggestions/names.title') }}
@endsection
@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">{{ trans('users/suggestions/names.panel_heading_show') }}</div>
        <div class="panel-body panel-show-suggestion">
            <h3>{{ $suggestion->content }}</h3>
            <div class="form-group">
                <div class="col-lg-4">
                    {{ trans('users/suggestions/names.label.subject') }}: {{ $suggestion->subject->name }}
                </div>
                <div class="col-lg-4">
                    {{ trans('users/suggestions/names.label.type') }}: {{ $suggestion->type }}
                </div>
                <div class="col-lg-4">
                    {{ trans('users/suggestions/names.label.created_at') }}: {{ $suggestion->created_at }}
                </div>
            </div>
            <hr>
            <div class="form-group">
                <ul>
                    @foreach ($suggestion->suggestionDetails as $suggestionDetail)
                        <li>
                            {{ trans('users/suggestions/names.label.option') }} {{ $loop->index + 1 }}: {{ $suggestionDetail->option }}
                            {!! $suggestionDetail->correct !!}
                        </li>
                    @endforeach
                </ul>
            </div>
            <hr>
            <div class="form-group">
                {{
                    Form::open([
                        'route' => ['suggestion.destroy', $suggestion->id],
                        'method' => 'DELETE',
                        'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'suggestion']) . '")'
                    ])
                }}
                    @if ($suggestion->status == trans('admins/suggestions/names.label_form.status.waiting'))
                        <a href="{{ route('suggestion.edit', ['id' => $suggestion->id]) }}" class="btn btn-warning">
                            {{ trans('names.button.button_edit') }}
                        </a>
                    @endif
                    <a href="{{ route('suggestion.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                    {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

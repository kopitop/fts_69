@extends('master')
@section('title')
    {{ trans('users/suggestions/names.title') }}
@endsection
@section('content')
    @if ($suggestions->count())
        <h3>
            {{ trans('users/suggestions/names.label.head_table') }}
            <a href="{{ route('suggestion.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>
        </h3>
        @include('layout.message')
        <table class="table table-hover">
            <thead>
            <tr id="head-table">
                <th>{{ trans('users/suggestions/names.label.created_at') }}</th>
                <th>{{ trans('users/suggestions/names.label.subject') }}</th>
                <th>{{ trans('users/suggestions/names.label.content') }}</th>
                <th>{{ trans('users/suggestions/names.label.type') }}</th>
                <th>{{ trans('users/suggestions/names.label.status') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($suggestions as $suggestion)
                <tr>
                    <td>{{ $suggestion->created_at }}</td>
                    <td>{{ $suggestion->subject->name }}</td>
                    <td>{{ $suggestion->content }}</td>
                    <td>{!! $suggestion->type !!} </td>
                    <td>{!! $suggestion->status !!} </td>
                    <td>
                        {{
                            Form::open([
                                'route' => ['suggestion.destroy', $suggestion->id],
                                'method' => 'DELETE',
                                'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'suggestion']) . '")'
                            ])
                        }}
                            <a href="{{ route('suggestion.show', ['id' => $suggestion->id]) }}" class="btn btn-primary">
                                {{ trans('names.button.button_view') }}
                            </a>
                            @if ($suggestion->status == trans('admins/suggestions/names.label_form.status.waiting'))
                                <a href="{{ route('suggestion.edit', ['id' => $suggestion->id]) }}" class="btn btn-warning">
                                    {{ trans('names.button.button_edit') }}
                                </a>
                            @endif
                            {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert">
            <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
            <p>{{ trans('messages.infor.not_found_lists', ['item' => 'suggestions']) }}</p>
        </div>
    @endif
@endsection

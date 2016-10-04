@extends('admins.master')
@section('title')
    {{ trans('admins/suggestions/names.title_suggestion_page') }}
@endsection
@section('heading')
    {{ trans('admins/suggestions/names.heading_suggestion_page') }}
@endsection
@section('action')
    {{ trans('admins/suggestions/names.action.list_suggestion') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/suggestions/names.panel.panel_head_list') }}</h3>
            <a href="{{ route('admin.suggestion.create') }}" class="btn btn-success btn-add"><i class="fa fa-plus"></i></a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                @include('layout.search')
                <hr>
                @if ($suggestions->count())
                    <table class="table table-bordered table-hover suggestion-lists" id="suggestion-list">
                        <thead>
                        <tr>
                            <th>{{ trans('admins/suggestions/names.label_form.user_name') }}</th>
                            <th>{{ trans('admins/suggestions/names.label_form.subject_name') }}</th>
                            <th>{{ trans('admins/suggestions/names.label_form.content') }}</th>
                            <th>{{ trans('admins/suggestions/names.label_form.status.name') }}</th>
                            <th>{{ trans('admins/suggestions/names.label_form.type') }}</th>
                            <th>{{ trans('admins/names.label.label_created_at') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suggestions as $suggestion)
                            <tr>
                                <td>{{ $suggestion->user->name }}</td>
                                <td>{{ $suggestion->subject->name }}</td>
                                <td>{{ $suggestion->content }}</td>
                                <td>{{ $suggestion->status }}</td>
                                <td>{{ $suggestion->type }}</td>
                                <th>{{ $suggestion->created_at }}</th>
                                <td>
                                    <div class="btn-group">
                                        {{
                                            Form::open([
                                                'route' => ['admin.suggestion.destroy', $suggestion->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'suggestions']) . '")'
                                            ])
                                        }}
                                            <a href="{{ route('admin.suggestion.show', ['id' => $suggestion->id]) }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-lightbulb-o"></i>
                                            </a>
                                            {{ Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
                                        {{ Form::close() }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_info">
                        {{
                            trans_choice('names.paginations', $suggestions->total(), [
                                'start' => $suggestions->firstItem(),
                                'finish' => $suggestions->lastItem(),
                                'numberOfRecords' => $suggestions->total()
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $suggestions->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'suggestion']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

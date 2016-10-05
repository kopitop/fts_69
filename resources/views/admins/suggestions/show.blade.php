@extends('admins.master')
@section('title')
    {{ trans('admins/suggestions/names.title_suggestion_page') }}
@endsection
@section('heading')
    {{ trans('admins/suggestions/names.heading_suggestion_page') }}
@endsection
@section('action')
    {{ trans('admins/suggestions/names.action.detail_suggestion') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/suggestions/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <ul>
                        <li>
                            {{ trans('admins/suggestions/names.label_form.user_name') }} : {{ $suggestion->user->name }}
                        </li>
                        <li>
                            {{ trans('admins/suggestions/names.label_form.subject_name') }} : {{ $suggestion->subject->name }}
                        </li>
                        <li>
                            {{ trans('admins/suggestions/names.label_form.content') }} : {{ $suggestion->content}}
                        </li>
                        <li>
                            {{ trans('admins/suggestions/names.label_form.type') }} : {{ $suggestion->type}}
                        </li>
                        <li>
                            {{ trans('admins/suggestions/names.label_form.status.name') }} : {{ $suggestion->status}}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    @if (count($suggestion->suggestionDetails))
                        @foreach($suggestion->suggestionDetails as $suggestionDetail)
                            <div class="form-group">
                                <h4><label>{{ trans('admins/suggestions/names.label_form.option', ['index' => $loop->index + 1]) }}</label></h4>
                                <label>{{ $suggestionDetail->option }}</label>
                                <h5><label>{{ trans('admins/suggestions/names.label_form.correct.name') }}</label> {!! $suggestionDetail->correct !!}</h5>
                                <hr>
                            </div>
                        @endforeach
                    @else
                        <div class="callout callout-info">
                            <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                            <p>{{ trans('messages.infor.not_found_lists', ['item' => 'suggestion detail']) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.suggestion.destroy', $suggestion->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'suggestion']) . '")'
                ])
            }}
                <a class="btn btn-warning" href="{{
                            ($suggestion->status == trans('admins/suggestions/names.label_form.status.confirm'))
                                ? "#"
                                : route('admin.suggestion.edit', ['id' => $suggestion->id])
                        }}"
                        {{
                            ($suggestion->status == trans('admins/suggestions/names.label_form.status.confirm'))
                            ? "disabled"
                            : ""
                        }}>
                    {{ trans('names.button.button_confirm') }}
                </a>
                <a href="{{ route('admin.suggestion.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection

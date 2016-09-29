@extends('admins.master')
@section('title')
    {{ trans('admins/questions/names.title_question_page') }}
@endsection
@section('heading')
    {{ trans('admins/questions/names.heading_question_page') }}
@endsection
@section('action')
    {{ trans('admins/questions/names.action.list_question') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/questions/names.panel.panel_head_list') }}</h3>
            <a href="{{ route('admin.question.create') }}" class="btn btn-success btn-add"><i class="fa fa-plus"></i></a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                @include('layout.search')
                <hr>
                @if ($questions->count())
                    <table class="table table-bordered table-hover question-lists" data-order="[[3, 'desc']]">
                        <thead>
                        <tr>
                            <th>{{ trans('admins/questions/names.label_form.subject_question') }}</th>
                            <th>{{ trans('admins/questions/names.label_form.type_question') }}</th>
                            <th>{{ trans('admins/questions/names.label_form.content_question') }}</th>
                            <th class="created-at">{{ trans('admins/names.label.label_created_at') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $question->subject->name }}</td>
                                    <td>
                                        {{
                                            ($question->type == config('common.question.type_question.single_choice')
                                                ? trans('admins/questions/names.label_form.single_choice')
                                                : ($question->type == config('common.question.type_question.multiple_choice')
                                                ? trans('admins/questions/names.label_form.multiple_choice')
                                                : trans('admins/questions/names.label_form.text')))
                                        }}
                                    </td>
                                    <td>{{ $question->content }}</td>
                                    <th class="created-at">{{ $question->created_at }}</th>
                                    <td>
                                        <div class="btn-group">
                                            {{
                                                Form::open([
                                                    'route' => ['admin.question.destroy', $question->id],
                                                    'method' => 'DELETE',
                                                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'question']) . '")'
                                                ])
                                            }}
                                                <a href="{{ route('admin.question.show', ['id' => $question->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-question"></i></a>
                                                <a href="{{ route('admin.question.edit', ['id' => $question->id]) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
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
                            trans_choice('names.paginations', $questions->total(), [
                                'start' => $questions->firstItem(),
                                'finish' => $questions->lastItem(),
                                'numberOfRecords' => $questions->total(),
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $questions->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'question']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/question_answers/names.title_question_answer_page') }}
@endsection
@section('heading')
    {{ trans('admins/question_answers/names.heading_question_answer_page') }}
@endsection
@section('action')
    {{ trans('admins/question_answers/names.action.list_question_answer') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/question_answers/names.panel.panel_head_list') }}</h3>
            <a href="{{ route('admin.question-answer.create') }}" class="btn btn-success btn-add"><i class="fa fa-plus"></i></a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                @include('layout.search')
                <hr>
                @if ($questionAnswers->count())
                    <table class="table table-bordered table-hover question_answer-lists" data-order='[[3,"desc"]]'>
                        <thead>
                        <tr>
                            <th>{{ trans('admins/question_answers/names.label_form.question_of_answer') }}</th>
                            <th>{{ trans('admins/question_answers/names.label_form.content_question_answer') }}</th>
                            <th>{{ trans('admins/question_answers/names.label_form.correct_question_answer') }}</th>
                            <th class="created-at">{{ trans('admins/names.label.label_created_at') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($questionAnswers as $questionAnswer)
                                <tr>
                                    <td>{{ (strlen($questionAnswer->question->content) > 50 ? substr($questionAnswer->question->content, 0, 50). "..." : $questionAnswer->question->content) }}</td>
                                    <td>{{ (strlen($questionAnswer->content) > 50 ? substr($questionAnswer->content, 0, 50). "..." : $questionAnswer->content) }}</td>
                                    <td>
                                        {{
                                            ($questionAnswer->question->type == config('common.question.type_question.text')
                                            ? trans('admins/questions/names.label_form.text')
                                            :($questionAnswer->correct == config('common.question_answer.correct.answer_true')
                                             ? trans('admins/question_answers/names.label_form.question_answer_true')
                                             : trans('admins/question_answers/names.label_form.question_answer_false')))
                                        }}
                                    </td>
                                    <th class="created-at">{{ $questionAnswer->created_at }}</th>
                                    <td>
                                        <div class="btn-group">
                                            {{
                                                Form::open([
                                                    'route' => ['admin.question-answer.destroy', $questionAnswer->id],
                                                    'method' => 'DELETE',
                                                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'answer of question']) . '")'
                                                ])
                                            }}
                                                <a href="{{ route('admin.question-answer.show', ['id' => $questionAnswer->id]) }}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-check-square-o"></i>
                                                </a>
                                                <a href="{{ route('admin.question-answer.edit', ['id' => $questionAnswer->id]) }}" class="btn btn-warning btn-xs">
                                                    <i class="fa fa-edit"></i>
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
                            trans_choice('names.paginations', $questionAnswers->total(), [
                                'start' => $questionAnswers->firstItem(),
                                'finish' => $questionAnswers->lastItem(),
                                'numberOfRecords' => $questionAnswers->total(),
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $questionAnswers->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'answer of question']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/questions/names.title_question_page') }}
@endsection
@section('heading')
    {{ trans('admins/questions/names.heading_question_page') }}
@endsection
@section('action')
    {{ trans('admins/questions/names.action.detail_question') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/questions/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#question" data-toggle="tab">{{ trans('admins/names.label.label_admin_question') }}</a></li>
                    <li><a href="#question-answer" data-toggle="tab">{{ trans('admins/names.label.label_admin_question_answer') }}</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="question">
                        <b>{{ trans('messages.infor.infor_name') }}</b>
                        <ul>
                            <li>{{ trans('admins/questions/names.label_form.subject_question') }} - {{ $question->subject->name }}</li>
                            <li>{{ trans('admins/questions/names.label_form.type_question') }} - {{ $question->type }}</li>
                            <li>{{ trans('admins/questions/names.label_form.content_question') }} - {{ $question->content }}</li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="question-answer">
                        <a href="{{ route('admin.question-answer.create') }}" class="btn btn-success">
                            <i class="fa fa-question"></i> {{ trans('names.button.button_add') }}
                        </a>
                        <hr>
                        @if (count($question->questionAnswers))
                            <table class="table table-bordered table-hover question-answer-lists">
                                <thead>
                                <tr>
                                    <th>{{ trans('admins/question_answers/names.label_form.content_question_answer') }}</th>
                                    <th>{{ trans('admins/question_answers/names.label_form.correct_question_answer') }}</th>
                                    <th>{{ trans('admins/names.label.label_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($question->questionAnswers as $questionAnswers)
                                    <tr>
                                        <td>{{ $questionAnswers->content }}</td>
                                        <td>{{ $questionAnswers->correct }}</td>
                                        <td>
                                            <div class="btn-group">
                                                {{
                                                    Form::open([
                                                        'route' => ['admin.question-answer.destroy', $questionAnswers->id],
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'question answer']) . '")'
                                                    ])
                                                }}
                                                    <a href="{{ route('admin.question-answer.show', ['id' => $questionAnswers->id]) }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                    <a href="{{ route('admin.question-answer.edit', ['id' => $questionAnswers->id]) }}" class="btn btn-warning btn-xs">
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
                        @else
                            <div class="callout callout-info">
                                <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                                <p>{{ trans('messages.infor.not_found_lists', ['item' => 'question answer']) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.question.destroy', $question->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'question']) . '")'
                ])
            }}
                <a href="{{ route('admin.question.edit', ['id' => $question->id]) }}" class="btn btn-warning">{{ trans('names.button.button_edit') }}</a>
                <a href="{{ route('admin.question.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection

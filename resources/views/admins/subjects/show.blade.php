@extends('admins.master')
@section('title')
    {{ trans('admins/subjects/names.title_subject_page') }}
@endsection
@section('heading')
    {{ trans('admins/subjects/names.heading_subject_page') }}
@endsection
@section('action')
    {{ trans('admins/subjects/names.action.detail_subject') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/subjects/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#subject" data-toggle="tab">{{ trans('admins/names.label.label_admin_subject') }}</a></li>
                    <li><a href="#question" data-toggle="tab">{{ trans('admins/names.label.label_admin_question') }}</a></li>
                    <li><a href="#exam" data-toggle="tab">{{ trans('admins/names.label.label_admin_exam') }}</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="subject">
                        <b>{{ trans('messages.infor.infor_name') }}</b>
                        <ul>
                            <li>{{ trans('admins/subjects/names.label_form.name_subject') }} - {{ $subject->name }}</li>
                            <li>{{ trans('admins/subjects/names.label_form.duration_subject') }} - {{ $subject->duration }}</li>
                            <li>{{ trans('admins/subjects/names.label_form.question_number_subject') }} - {{ $subject->number_question }}</li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="question">
                        @if (count($subject->question))
                            <table class="table table-bordered table-hover question-lists">
                                <thead>
                                <tr>
                                    <th>{{ trans('admins/questions/names.label_form.type_question') }}</th>
                                    <th>{{ trans('admins/questions/names.label_form.content_question') }}</th>
                                    <th>{{ trans('admins/names.label.label_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subject->question as $question)
                                    <tr>
                                        <td>{{ $question->type }}</td>
                                        <td>{{ $question->content }}</td>
                                        <td>
                                            <div class="btn-group">
                                                {{
                                                    Form::open([
                                                        'route' => ['admin.question.destroy', $question->id],
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'question']) . '")'
                                                    ])
                                                }}
                                                    <a href="{{ route('admin.question.show', ['id' => $question->id]) }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                    <a href="{{ route('admin.question.edit', ['id' => $question->id]) }}" class="btn btn-warning btn-xs">
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
                            <a href="{{ route('admin.question.create') }}" class="btn btn-success">
                                <i class="fa fa-question"></i> {{ trans('names.button.button_add') }}
                            </a>
                            <hr>
                            <div class="callout callout-info">
                                <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                                <p>{{ trans('messages.infor.not_found_lists', ['item' => 'question']) }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="exam">
                        @if (count($subject->exam))
                            <table class="table table-bordered table-hover exam-lists">
                                <thead>
                                <tr>
                                    <th>{{ trans('admins/exams/names.label_form.name_exam') }}</th>
                                    <th>{{ trans('admins/names.label.label_created_at') }}</th>
                                    <th>{{ trans('admins/names.label.label_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subject->exam as $exam)
                                    <tr>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->created_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                {{
                                                    Form::open([
                                                        'route' => ['admin.exam.destroy', $exam->id],
                                                        'method' => 'DELETE',
                                                        'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'exam']) . '")'
                                                    ])
                                                }}
                                                    <a href="{{ route('admin.exam.show', ['id' => $exam->id]) }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-book"></i>
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
                            <a href="{{ route('admin.exam.create') }}" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i> {{ trans('names.button.button_add') }}
                            </a>
                            <hr>
                            <div class="callout callout-info">
                                <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                                <p>{{ trans('messages.infor.not_found_lists', ['item' => 'exam']) }}</p>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.subject.destroy', $subject->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'subject']) . '")'
                ])
            }}
                <a href="{{ route('admin.subject.edit', ['id' => $subject->id]) }}" class="btn btn-warning">{{ trans('names.button.button_edit') }}</a>
                <a href="{{ route('admin.subject.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection

@extends('admins.master')
@section('title')
    {{ trans('admins/exams/names.title_exam_page') }}
@endsection
@section('heading')
    {{ trans('admins/exams/names.heading_exam_page') }}
@endsection
@section('action')
    {{ trans('admins/exams/names.action.list_exam') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/exams/names.panel.panel_head_list') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                @include('layout.search')
                <hr>
                @if ($exams->count())
                    <table class="table table-bordered table-hover exam-lists">
                        <thead>
                        <tr>
                            <th>{{ trans('admins/exams/names.label_form.user_name') }}</th>
                            <th>{{ trans('admins/exams/names.label_form.subject_exam') }}</th>
                            <th>{{ trans('admins/exams/names.label_form.name_exam') }}</th>
                            <th>{{ trans('admins/exams/names.label_form.result_exam') }}</th>
                            <th>{{ trans('admins/exams/names.label_form.status_exam') }}</th>
                            <th>{{ trans('admins/exams/names.label_form.time_spent_exam') }}</th>
                            <th class="created-at">{{ trans('admins/names.label.label_created_at') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $exam)
                                <tr>
                                    <td>
                                        {{ ((count($exam->examResult)) ? $exam->examResult->user->name : "") }}
                                    </td>
                                    <td>{{ $exam->subject->name }}</td>
                                    <td>{!! $exam->name !!}</td>
                                    <td>
                                        {{ ((count($exam->examResult)) ? $exam->examResult->result : "") }}
                                    </td>
                                    <td>
                                        {!! ((count($exam->examStatus)) ? $exam->examStatus->status : "") !!}
                                    </td>
                                    <td>
                                        {{ ((count($exam->examResult)) ? $exam->examResult->time_spent : "") }}
                                    </td>
                                    <th class="created-at">{{ $exam->created_at }}</th>
                                    <td>
                                        <div class="btn-group">
                                            {{
                                                Form::open([
                                                    'route' => ['admin.exam.destroy', $exam->id],
                                                    'method' => 'DELETE',
                                                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'exam']) . '")'
                                                ])
                                            }}
                                                <a href="{{ ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_save') ||
                                                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_testing')
                                                            ? "#" : route('admin.exam.show', ['id' => $exam->id])) }}"
                                                    class="btn btn-primary btn-xs"
                                                        {{ ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_save') ||
                                                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_testing')) ? 'disabled' : null }}>
                                                    <i class="fa fa-file-text-o"></i>
                                                </a>
                                                <a href="{{ ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_unchecked') ||
                                                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')
                                                            ?route('admin.exam.edit', ['id' => $exam->id]) :  "#") }}" class="btn btn-warning btn-xs"
                                                        {{ ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_unchecked') ||
                                                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')) ? null:  'disabled' }}>
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                {{ Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs',
                                                        ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_save') ||
                                                        $exam->examStatus->status == trans('admins/exams/names.label_form.exam_testing')) ? 'disabled' : null])
                                                }}
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_info">
                        {{
                            trans_choice('names.paginations', $exams->total(), [
                                'start' => $exams->firstItem(),
                                'finish' => $exams->lastItem(),
                                'numberOfRecords' => $exams->total(),
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $exams->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa -info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'exam']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

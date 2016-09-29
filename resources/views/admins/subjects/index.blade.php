@extends('admins.master')
@section('title')
    {{ trans('admins/subjects/names.title_subject_page') }}
@endsection
@section('heading')
    {{ trans('admins/subjects/names.heading_subject_page') }}
@endsection
@section('action')
    {{ trans('admins/subjects/names.action.list_subject') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/subjects/names.panel.panel_head_list') }}</h3>
            <a href="{{ route('admin.subject.create') }}" class="btn btn-success btn-add"><i class="fa fa-plus"></i></a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                @include('layout.search')
                <hr>
                @if ($subjects->count())
                    <table id="subject-lists" class="table table-bordered table-hover" data-order="[[3, 'desc']]">
                        <thead>
                        <tr>
                            <th>{{ trans('admins/subjects/names.label_form.name_subject') }}</th>
                            <th>{{ trans('admins/subjects/names.label_form.duration_subject') }}</th>
                            <th>{{ trans('admins/subjects/names.label_form.question_number_subject') }}</th>
                            <th>{{ trans('admins/names.label.label_created_at') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->duration }}</td>
                                    <td>{{ $subject->number_question }}</td>
                                    <th>{{ $subject->created_at }}</th>
                                    <td>
                                        <div class="btn-group">
                                            {{
                                                Form::open([
                                                    'route' => ['admin.subject.destroy', $subject->id],
                                                    'method' => 'DELETE',
                                                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'subject']) . '")'
                                                ])
                                            }}
                                                <a href="{{ route('admin.subject.show', ['id' => $subject->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-book"></i></a>
                                                <a href="{{ route('admin.subject.edit', ['id' => $subject->id]) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
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
                            trans_choice('names.paginations', $subjects->total(), [
                                'start' => $subjects->firstItem(),
                                'finish' => $subjects->lastItem(),
                                'numberOfRecords' => $subjects->total()
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $subjects->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'subject']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection

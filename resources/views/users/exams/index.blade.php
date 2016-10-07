@extends('master')
@section('title')
    {{ trans('users/exams/names.title') }}
@endsection
@section('content')
    <div class="row" id="exam-list">
        {{ Form::open(['route' => 'exam.store', 'method' => 'POST', 'class' => 'form-inline']) }}
            <div class="form-group">
                {{ Form::select('subject_id', $subjects, null, ['class' => 'form-control']) }}
                {{ Form::button(trans('names.button.button_create_exam'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        {{ Form::close() }}
        <hr>
        @include('layout.message')
        @if ($exams->count())
            <h3>{{ trans('users/exams/names.label.head_table') }}</h3>
            <table class="table table-hover">
                <thead>
                <tr id="head-table">
                    <th>{{ trans('users/exams/names.label.created_at') }}</th>
                    <th>{{ trans('users/exams/names.label.subject') }}</th>
                    <th>{{ trans('users/exams/names.label.status') }}</th>
                    <th>{{ trans('users/exams/names.label.duration') }}</th>
                    <th>{{ trans('users/exams/names.label.question_number') }}</th>
                    <th>{{ trans('users/exams/names.label.spent_time') }}</th>
                    <th>{{ trans('users/exams/names.label.score') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->created_at }}</td>
                        <td>{{ $exam->subject->name }}</td>
                        <td>{!! $exam->examStatus->status !!} </td>
                        <td>{{ $exam->subject->duration }}</td>
                        <td>{{ $exam->subject->number_question }}</td>
                        <td>{{ (count($exam->examResult) == 0) ? "-" : $exam->examResult->time_spent }}</td>
                        <td>{{ (count($exam->examResult) == 0) ? "-" : $exam->examResult->result }}</td>
                        <td>
                            @if ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')
                                || $exam->examStatus->status == trans('admins/exams/names.label_form.exam_unchecked'))
                                <a href="{{ route('exam.edit', ['id' => $exam->id]) }}" class="btn btn-success btn-xs">
                                    {{ trans('names.button.button_view') }}
                                </a>
                            @else
                                <a href="{{ route('exam.show', ['id' => $exam->id]) }}" class="btn btn-primary btn-xs">
                                    {{ trans('names.button.button_start_exam') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="callout callout-info">
                <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                <p>{{ trans('messages.infor.not_found_lists', ['item' => 'exam']) }}</p>
            </div>
        @endif
    </div>
@endsection

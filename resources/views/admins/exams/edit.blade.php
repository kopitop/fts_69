@extends('admins.master')
@section('title')
    {{ trans('admins/exams/names.title_exam_page') }}
@endsection
@section('heading')
    {{ trans('admins/exams/names.heading_exam_page') }}
@endsection
@section('action')
    {{ trans('admins/exams/names.action.detail_exam') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/exams/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="col-lg-10 col-lg-offset-1 exam">
                <h1>{!! $exam->name !!}</h1>
                <div class="row">
                    <div class="col-lg-6">
                        <h3 id="user">{{ trans('admins/exams/names.label_form.user_name') }}: {{ $exam->examResult->user->name }}</h3>
                    </div>
                    <div class="col-lg-6">
                        <h3 id="time-spent">{{ trans('admins/exams/names.label_form.time_spent_exam') }}: {{ $exam->examResult->time_spent }}</h3>
                    </div>
                </div>
                <hr>
                <div class="row">
                    @if (count($exam->examQuestions))
                        {{ Form::open(['route' => ['check.update', 'id' => $exam->id], 'method' => 'PUT', ]) }}
                        {{ Form::hidden('user', $exam->examResult->user->id) }}
                        @foreach($exam->examQuestions as $questionExam)
                            <label><b>{{ $loop->index + 1 }}</b>: <i>{{$questionExam->question->content}}</i></label>
                            @if ($questionExam->question->type == config('common.question.type_question.text'))
                                @foreach($questionExam->question->questionAnswers as $questionAnswer)
                                    @if (in_array($questionAnswer->id, $exam->userQuestions->pluck('question_answer_id')->toArray()))
                                        <div class="form-group">
                                            <textarea class="form-control" disabled>{{ $questionAnswer->content }}</textarea>
                                            <label class="radio-inline" for="{{ trans('names.label.label_for', ['label_for' => 'true']) }}">
                                                <input type="radio" name="choice_text[{{ $questionAnswer->id }}]" {{ ($questionAnswer->correct == config('common.question_answer.correct.answer_true') ? "checked" : null) }}
                                                value="{{ config('common.question_answer.correct.answer_true') }}">
                                                {{ trans('admins/question_answers/names.label_form.question_answer_true') }}
                                            </label>
                                            <label class="radio-inline" for="{{ trans('names.label.label_for', ['label_for' => 'false']) }}">
                                                <input type="radio" name="choice_text[{{ $questionAnswer->id }}]"  {{ ($questionAnswer->correct == config('common.question_answer.correct.answer_false') ? "checked" : null) }}
                                                       value="{{ config('common.question_answer.correct.answer_false') }}">
                                                {{ trans('admins/question_answers/names.label_form.question_answer_false') }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            @elseif ($questionExam->question->type == config('common.question.type_question.multiple_choice'))
                                @if (count($questionExam->question->questionAnswers))
                                    @foreach($questionExam->question->questionAnswers as $questionAnswer)
                                        @if (in_array($questionAnswer->id, $exam->userQuestions->pluck('question_answer_id')->toArray()))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" disabled checked>{{ $questionAnswer->content }}
                                                </label>
                                            </div>
                                        @else
                                            <div class="checkbox">
                                                <label><input type="checkbox" disabled>{{ $questionAnswer->content }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                @if (count($questionExam->question->questionAnswers))
                                    @foreach($questionExam->question->questionAnswers as $questionAnswer)
                                        @if (in_array($questionAnswer->id, $exam->userQuestions->pluck('question_answer_id')->toArray()))
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" disabled checked>{{ $questionAnswer->content }}
                                                </label>
                                            </div>
                                        @else
                                            <div class="radio">
                                                <label><input type="radio" disabled>{{ $questionAnswer->content }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            <div class="form-group">
                                {!! $answer[$loop->index][$questionExam->question->id] !!}
                            </div>
                        @endforeach
                        <hr>
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-6">
                                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    @else
                        <div class="callout callout-info">
                            <h4><i class="icon fa fa -info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                            <p>{{ trans('messages.infor.not_found_lists', ['item' => 'question of exam']) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
@endsection

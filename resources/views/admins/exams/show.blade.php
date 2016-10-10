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
                {!! $exam->name !!}
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
                        @foreach ($exam->examQuestions as $examQuestion)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h4><b>{{ $examQuestion->question->content }}</b></h4>
                                    @if ($examQuestion->question->type == config('common.question.type_question.single_choice'))
                                        @if (count($examQuestion->question->questionAnswers))
                                            @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="choice_single[{{$examQuestion->question->id}}]" disabled value="{{ $questionAnswers->id }}"
                                                                {{ ($exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id)) ? "checked" : "" }}>
                                                        {{ $questionAnswers->content }}
                                                    </label>
                                                </div>

                                            @endforeach
                                        @endif
                                        <div class="form-group">
                                            {!! $answer[$loop->index][$examQuestion->question->id] !!}
                                        </div>
                                    @elseif ($examQuestion->question->type == config('common.question.type_question.multiple_choice'))
                                        @if (count($examQuestion->question->questionAnswers))
                                            @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="choice_multiple[{{$examQuestion->question->id}}][]" disabled value="{{ $questionAnswers->id }}"
                                                                {{ ($exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id)) ? "checked" : "" }}>
                                                        {{ $questionAnswers->content }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="form-group">
                                            {!! $answer[$loop->index][$examQuestion->question->id] !!}
                                        </div>
                                    @else
                                        <div class="form-group">
                                            @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                                @if ($exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id))
                                                    <textarea class="form-control" disabled rows="5" name="text[{{$examQuestion->question->id}}]">{{ $questionAnswers->content }}</textarea>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            {!! $answer[$loop->index][$examQuestion->question->id] !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="callout callout-info">
                            <h4><i class="icon fa fa -info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                            <p>{{ trans('messages.infor.not_found_lists', ['item' => 'question of exam']) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.exam.update', $exam->id],
                    'method' => 'PUT',
                ])
            }}
                <input type="hidden" name="user_id" value="{{ $exam->examResult->user->id }}">
                <a href="{{ ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_unchecked') ||
                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')
                            ? route('admin.exam.edit', ['id' => $exam->id]) : '#') }}"
                   class="btn btn-primary"
                        {{ (($exam->examStatus->status == trans('admins/exams/names.label_form.exam_unchecked') ||
                            $exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')) ? null :'disabled') }}>
                    {{ trans('names.button.button_rechecked') }}
                </a>
                <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{
                    Form::button(
                        trans('names.button.button_confirm'),
                        ['type' => 'submit', 'class' => 'btn btn-primary',
                            ($exam->examStatus->status == trans('admins/exams/names.label_form.exam_checked')) ? 'disabled' : null
                        ])
                }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection

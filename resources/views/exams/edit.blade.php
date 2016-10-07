@extends('master')
@section('title')
    {{ trans('users/exams/names.title') }}
@endsection
@section('content')
    <div class="row exam-header">
        {!! $exam->name !!}
    </div>
    <div class="row">
        <div class="col-lg-1 col-lg-offset-11">
            <h3 class="time-spent">
                {{ trans('users/exams/names.label.time') }} <span class="label label-danger">{{ $exam->examResult->time_spent }}</span>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
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
                <hr>
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-3">
                        <a href="{{ route('exam.index') }}" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-arrow-left">
                            </span> {{ trans('names.button.button_back') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

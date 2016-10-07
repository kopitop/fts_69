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
            <h3 class="time-spent">{{ trans('users/exams/names.label.time') }}
                <span class="time label label-danger" id="{{ $duration }}">{{ $duration }}</span>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            @if (count($exam->examQuestions))
                {{ Form::open(['route' => ['result.update', $exam->id], 'method' => 'PUT', 'id' => 'form-exam']) }}
                    <input type="hidden" name="time_spent" class="time_input">
                    @foreach ($exam->examQuestions as $examQuestion)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4><b>{{ $examQuestion->question->content }}</b></h4>
                                @if ($examQuestion->question->type == config('common.question.type_question.single_choice'))
                                    @if (count($examQuestion->question->questionAnswers))
                                        @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="choice_single[{{$examQuestion->question->id}}]" value="{{ $questionAnswers->id }}"
                                                    {{ (count($exam->userQuestions->pluck('question_answer_id')) &&
                                                    $exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id)) ? "checked" : "" }}>
                                                    {{ $questionAnswers->content }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                @elseif ($examQuestion->question->type == config('common.question.type_question.multiple_choice'))
                                    @if (count($examQuestion->question->questionAnswers))
                                        @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="choice_multiple[{{$examQuestion->question->id}}][]" value="{{ $questionAnswers->id }}"
                                                    {{ (count($exam->userQuestions->pluck('question_answer_id')) &&
                                                    $exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id)) ? "checked" : "" }}>
                                                    {{ $questionAnswers->content }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                @else
                                    <div class="form-group">

                                        @if (count($exam->userQuestions->pluck('question_answer_id')))
                                            @foreach ($examQuestion->question->questionAnswers as $questionAnswers)
                                                @if ($exam->userQuestions->pluck('question_answer_id')->contains($questionAnswers->id))
                                                    <textarea class="form-control" rows="5" name="text[{{$examQuestion->question->id}}]">{{ $questionAnswers->content }}</textarea>
                                                    @break;
                                                @else
                                                    @if ($loop->index == count($examQuestion->question->questionAnswers) - 1)
                                                        <textarea class="form-control" rows="5" name="text[{{$examQuestion->question->id}}]"></textarea>
                                                    @else
                                                        @continue;
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <textarea class="form-control" rows="5" name="text[{{$examQuestion->question->id}}]"></textarea>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3 btn-exam-action">
                            <button class="btn btn-warning" name="btn_exam" value="save" type="submit">
                                <span class="glyphicon glyphicon-save"></span> {{ trans('names.button.button_save') }}
                            </button>
                            <button class="btn btn-success" name="btn_exam" value="finish" type="submit">
                                <span class="glyphicon glyphicon-ok"></span> {{ trans('names.button.button_submit') }}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            @endif
        </div>
    </div>
@endsection

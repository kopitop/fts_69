<?php

namespace App\Repositories\Suggestion;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Subject;
use App\Models\Suggestion;
use App\Models\SuggestionDetail;
use App\Repositories\BaseRepository;
use Exception;
use DB;

class SuggestionRepository extends BaseRepository implements SuggestionRepositoryInterface
{
    public function __construct(Suggestion $suggestion)
    {
        $this->model = $suggestion;
    }

    public function show($id = null)
    {
        return Suggestion::with('user', 'subject', 'suggestionDetails')->find($id);
    }

    public function confirm($id)
    {
        $suggestion = Suggestion::with('suggestionDetails')->find($id);
        try {
            DB::beginTransaction();
            $question = Question::firstOrCreate([
                'subject_id' => $suggestion->subject_id,
                'type' => $suggestion->type,
                'content' => $suggestion->content,
            ]);

            if (count($suggestion->suggestionDetails)) {
                $config = config('common.question_answer.correct');
                $trans = trans('admins/suggestions/names.label_form.correct');
                foreach ($suggestion->suggestionDetails as $suggestionDetail) {
                    $dataQuestionAnswer[] = [
                        'question_id' => $question->id,
                        'correct' => ($suggestionDetail->correct == $trans['true']) ? $config['answer_true'] : $config['answer_false'],
                        'content' => $suggestionDetail->option,
                    ];
                }
                QuestionAnswer::insert($dataQuestionAnswer);
            }

            $suggestion->update(['status' => config('common.suggestion.status.confirm')]);
            DB::commit();
            $message = trans('messages.success.update_success', ['item' => 'suggestion']);
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.update_error', ['item' => 'suggestion']);
        }

        return $message;
    }

    public function delete($ids)
    {
        $suggestion = Suggestion::findOrFail($ids);

        try {
            DB::beginTransaction();

            /**
             * delete suggestion detail
             */
            SuggestionDetail::where('suggestion_id', $suggestion->id)->delete();

            /**
             * delete suggestion
             */
            $suggestion->delete();
            DB::commit();
            $message = trans('messages.success.delete_success', ['item' => 'suggestion']);
        } catch (Exception $e) {
            DB::rollBack();
            $message = trans('messages.error.delete_error', ['item' => 'suggestion']);
        }

        return $message;
    }

    public function index($userId)
    {
        return Suggestion::with('suggestionDetails', 'subject')->orderBy('created_at', config('common.sort.sort_descending'))->where('user_id', $userId)->get();
    }

    public function store($input)
    {
        $type = $input['type'];
        $contentText = $input['content_text'];
        $contentMultipleChoice = $input['content_multiple_choice'];
        $correctMultipleChoice = $input['correct_multiple_choice'];
        $contentSingleChoice = $input['content_single_choice'];
        $correctSingleChoice = $input['correct_single_choice'];
        $config = config('common.question.type_question');
        $dataSuggestionDetail = null;

        try {
            DB::beginTransaction();

            $dataSuggestion = Suggestion::firstOrCreate([
                'user_id' => auth()->user()->id,
                'subject_id' => $input['subject_id'],
                'content' => $input['content'],
                'type' => $input['type'],
                'status' => config('common.suggestion.status.waiting'),
            ]);
            if ($type == $config['text']) {
                foreach ($contentText as $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => config('common.suggestion_detail.correct.false'),
                    ];
                }
            } elseif ($type == $config['multiple_choice']) {
                foreach ($contentMultipleChoice as $key => $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => array_key_exists($key, $correctMultipleChoice)
                            ? $correctMultipleChoice[$key] : config('common.suggestion_detail.correct.false'),
                    ];
                }
            } else {
                foreach ($contentSingleChoice as $key => $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => (str_contains($correctSingleChoice, $key))
                            ? config('common.suggestion_detail.correct.true')
                            : config('common.suggestion_detail.correct.false'),
                    ];
                }
            }

            SuggestionDetail::insert($dataSuggestionDetail);
            DB::commit();
            $message = trans('messages.success.create_success', ['item' => 'suggestion']);
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.create_error', ['item' => 'suggestion']);
        }

        return $message;
    }

    public function userCreate()
    {
        $trans = trans('admins/questions/names.label_form');
        $config = config('common.question.type_question');
        $subjects = Subject::orderBy('created_at', config('common.sort.descending'))->pluck('name', 'id');
        $types = [
            $config['single_choice'] => $trans['single_choice'],
            $config['multiple_choice'] => $trans['multiple_choice'],
            $config['text'] => $trans['text'],
        ];
        $data = json_encode([
            'key' => [
                'single' => $config['single_choice'],
                'multiple' => $config['multiple_choice'],
                'text' => $config['text'],
            ],
            'view' => [
                'text' => view('layout.option-text')->render(),
                'multiple' => view('layout.option-multiple-choice')->render(),
                'single' => view('layout.option-single-choice')->render(),
            ],
            'oldInput' => session("_old_input"),
        ]);

        return compact('subjects', 'types', 'data');
    }

    public function edit($id)
    {
        $suggestion = Suggestion::with('subject', 'suggestionDetails')->find($id);
        $config = config('common.question.type_question');
        $trans = trans('admins/questions/names.label_form');
        $type = $config['single_choice'];

        switch ($suggestion->type) {
            case $trans['multiple_choice']:
                $type = $config['multiple_choice'];
                break;
            case $trans['text']:
                $type = $config['text'];
                break;
        }
        $dataSystem =  $this->userCreate();
        $dataRtn = [
            'subjects' => $dataSystem['subjects'],
            'types' => $dataSystem['types'],
            'data' => $dataSystem['data'],
            'suggestion' => $suggestion,
            'type' => $type
        ];

        return $dataRtn;
    }

    public function update($inputs, $id)
    {
        $suggestion = Suggestion::findOrFail($id);
        try {
            DB::beginTransaction();
            $type = $inputs['type'];
            $correctMultipleChoice = $inputs['correct_multiple_choice'];
            $correctSingleChoice = $inputs['correct_single_choice'];
            $suggestion->update([
                'subject_id' => $inputs['subject_id'],
                'content' => $inputs['content'],
            ]);

            foreach ($inputs['content_option'] as $suggestionDetailId=>$value) {
                $data['option'] = $value;
                if (array_key_exists($suggestionDetailId, $inputs['correct_option'])) {
                    $data['correct'] = $inputs['correct_option'][$suggestionDetailId];
                } else {
                    $data['correct'] = config('common.suggestion_detail.correct.false');
                }

                SuggestionDetail::where('id', $suggestionDetailId)->update($data);
            }

            if ($type == config('common.question.type_question.text')) {
                if (count($inputs['content_text'])) {
                    foreach ($inputs['content_text'] as $value) {
                        $dataInsert[] = [
                            'suggestion_id' => $id,
                            'option' => $value,
                            'correct' => config('common.suggestion_detail.correct.false'),
                        ];
                    }
                }
            } elseif ($type == config('common.question.type_question.multiple_choice')) {
                if (count($inputs['content_multiple_choice'])) {
                    foreach ($inputs['content_multiple_choice'] as $key => $value) {
                        if (is_null($correctMultipleChoice)) {
                            $dataInsert[] = [
                                'suggestion_id' => $id,
                                'option' => $value,
                                'correct' => config('common.suggestion_detail.correct.false'),
                            ];
                        } else {
                            $dataInsert[] = [
                                'suggestion_id' => $id,
                                'option' => $value,
                                'correct' => array_key_exists($key, $correctMultipleChoice)
                                    ? $correctMultipleChoice[$key] : config('common.suggestion_detail.correct.false'),
                            ];
                        }
                    }
                }
            } else {
                if (count($inputs['content_single_choice'])) {
                    foreach ($inputs['content_single_choice'] as $key => $value) {
                        if (is_null($correctSingleChoice)) {
                            $dataInsert[] = [
                                'suggestion_id' => $id,
                                'option' => $value,
                                'correct' => config('common.suggestion_detail.correct.false'),
                            ];
                        } else {
                            $dataInsert[] = [
                                'suggestion_id' => $id,
                                'option' => $value,
                                'correct' => (str_contains($correctSingleChoice, $key))
                                    ? config('common.suggestion_detail.correct.true')
                                    : config('common.suggestion_detail.correct.false'),
                            ];
                        }

                    }
                }
            }

            if (isset($dataInsert)) {
                SuggestionDetail::insert($dataInsert);
            }

            DB::commit();
            $message = trans('messages.success.update_success', ['item' => 'suggestion']);
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.update_error', ['item' => 'suggestion']);
        }

        return $message;
    }

    public function deleteSuggestionDetail($id)
    {
        $suggestionDetail = SuggestionDetail::find($id);
        $suggestionId = $suggestionDetail->suggestion_id;
        $suggestionDetail->delete();
        $suggestion = Suggestion::with('suggestionDetails')->find($suggestionId);
        $config = config('common.question.type_question');
        $trans = trans('admins/questions/names.label_form');
        $type = $config['single_choice'];

        switch ($suggestion->type) {
            case $trans['multiple_choice']:
                $type = $config['multiple_choice'];
                break;
            case $trans['text']:
                $type = $config['text'];
                break;
        }
        $data = json_encode([
            'isSuccess' => true,
            'suggestionDetail' => view('layout.suggestion-detail', [
                'suggestion' => $suggestion,
                'type' => $type,
            ])->render(),
        ]);

        return $data;
    }

}

<?php

namespace App\Repositories\Suggestion;

use App\Models\Question;
use App\Models\QuestionAnswer;
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
        return Suggestion::with('suggestionDetails', 'subject')->where('user_id', $userId)->get();
    }

    public function store($input)
    {
        $type = $input['type'];
        $content_text = $input['content_text'];
        $content_multiple_choice = $input['content_multiple_choice'];
        $correct_multiple_choice = $input['correct_multiple_choice'];
        $content_single_choice = $input['content_single_choice'];
        $correct_single_choice = $input['correct_single_choice'];
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
                foreach ($content_text as $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => config('common.suggestion_detail.correct.false'),
                    ];
                }
            } elseif ($type == $config['multiple_choice']) {
                foreach ($content_multiple_choice as $key => $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => array_key_exists($key, $correct_multiple_choice)
                            ? $correct_multiple_choice[$key]
                            : config('common.suggestion_detail.correct.false'),
                    ];
                }
            } else {
                foreach ($content_single_choice as $key => $value) {
                    $dataSuggestionDetail[] = [
                        'suggestion_id' => $dataSuggestion->id,
                        'option' => $value,
                        'correct' => (str_contains($correct_single_choice, $key))
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
}

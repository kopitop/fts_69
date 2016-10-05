<?php

namespace App\Repositories\Suggestion;

use App\Models\Suggestion;
use App\Repositories\BaseRepository;

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
}

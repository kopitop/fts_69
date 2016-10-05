<?php

/*
 /--------------------------------------------------------------------
 / Route admin
 /--------------------------------------------------------------------
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::resource('user', 'UserController');
    Route::resource('subject', 'SubjectController');
    Route::resource('question', 'QuestionController');
    Route::resource('exam', 'ExamController');
    Route::resource('question-answer', 'QuestionAnswerController');
    Route::resource('suggestion', 'SuggestionController', ['except' => [
        'create', 'store', 'update'
    ]]);
});

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

/*
 /--------------------------------------------------------------------
 / Route login - logout
 /--------------------------------------------------------------------
 */
Route::group(['namespace' => 'Account'], function () {
    Route::resource('login', 'LoginController', ['only' => [
        'index', 'store'
    ]]);
    Route::resource('register', 'RegisterController', ['only' => [
        'index', 'store'
    ]]);
    Route::resource('forgot-password', 'PasswordController', ['only' => [
        'index', 'store'
    ]]);
    Route::resource('reset-password', 'ResetPassword', ['only' => [
        'store', 'show'
    ]]);
});

/*
/--------------------------------------------------------------------
/ Route user
/--------------------------------------------------------------------
*/
Route::group(['namespace' => 'User'], function () {
    Route::resource('profile', 'ProfileController', ['only' => [
        'index', 'update', 'destroy'
    ]]);
    Route::resource('password', 'PasswordController', ['only' => [
        'store'
    ]]);
    Route::resource('exam', 'ExamController');
});

/*
/--------------------------------------------------------------------
/ Route exam
/--------------------------------------------------------------------
*/
Route::resource('result', 'ResultController', ['only' => [
    'update'
]]);

<?php

/*
 /--------------------------------------------------------------------
 / Route admin
 /--------------------------------------------------------------------
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::resource('user', 'UserController');
    Route::resource('subject', 'SubjectController');
    Route::resource('question', 'QuestionController');
    Route::resource('exam', 'ExamController', ['except' => [
        'create', 'destroy', 'store'
    ]]);
    Route::resource('question-answer', 'QuestionAnswerController');
    Route::resource('suggestion', 'SuggestionController', ['except' => [
        'create', 'store', 'update'
    ]]);
    Route::resource('profile', 'ProfileController', ['only' => [
        'index', 'update'
    ]]);
    Route::resource('password', 'PasswordController', ['only' => [
        'store'
    ]]);
    Route::resource('check', 'CheckController', ['only' => [
        'update'
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
    Route::resource('exam', 'ExamController', ['except' => [
        'create', 'destroy', 'update'
    ]]);
    Route::resource('suggestion', 'SuggestionController');
    Route::resource('suggestion-detail', 'SuggestionDetailController', ['only' => [
        'store'
    ]]);
});

/*
/--------------------------------------------------------------------
/ Route user
/--------------------------------------------------------------------
*/
Route::group(['namespace' => 'User', 'middleware' => 'user'], function () {
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

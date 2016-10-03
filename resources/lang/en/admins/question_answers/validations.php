<?php

return [
    'question_id' => [
        'required' => 'Please choose question of answer',
        'exists' => 'Question not found in system. Please check again!',
    ],
    'content' => [
        'required' => 'Please enter content of option :indexOption',
        'max' => 'Content of option :indexOption is maximum 255 characters',
        'not_found' => 'Not found content of option. Please check again!'
    ],
    'correct' => [
        'choice' => 'Number of correct answer incorrect with type of question. Please check again',
    ],
];

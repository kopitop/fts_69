<?php

return [
    'question_id' => [
        'required' => 'Please choose question of answer',
        'exists' => 'Question not found in system. Please check again',
    ],
    'content' => [
        'option' => 'Content invalid. Content is required and maximum is 255 characters. Please check again!',
    ],
    'correct' => [
        'choice' => 'Number of correct answer incorrect with type of question. Please check again',
    ],
];

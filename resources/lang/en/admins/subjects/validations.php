<?php

return [
    'name' => [
        'required' => 'Please enter name of subject',
        'max' => 'Name of subject is maximum 20 characters',
    ],
    'duration' => [
        'required' => 'Please enter duration of subject',
        'numeric' => 'Duration of subject must is numeric',
    ],
    'number_question' => [
        'required' => 'Please enter question number of subject',
        'numeric' => 'Question number of subject must is numeric',
    ],
];

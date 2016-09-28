<?php

return [
    'subject_id' => [
        'required' => 'Please choose subject of question',
        'exists' => 'Subject not found in system. Please check again',
    ],
    'type' => [
        'required' => 'Please choose answer type of question',
        'in' => 'Type is incorrect. Please check again',
    ],
    'content' => [
        'required' => 'Please enter content of question',
        'max' => 'Content of question is maximum 255 characters',
    ],
];

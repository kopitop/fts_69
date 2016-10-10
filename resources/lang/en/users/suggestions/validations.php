<?php

return [
    'subject' => [
        'required' => 'Please choose subject of suggestions',
        'exists' => 'Subject not found in system. Please check again!',
    ],
    'type' => [
        'required' => 'Please choose type of suggestions',
    ],
    'content' => [
        'required' => 'Please enter content of suggestion',
        'max' => 'Content of suggestion is maximum 255 characters',
    ],
    'content_option' => [
        'required' => 'Please enter content of option :indexOption',
        'max' => 'Content of option :indexOption is maximum 255 characters',
        'not_found' => 'Not found content of option. Please check again!'
    ],
];

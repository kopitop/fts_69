<?php

return [
    'path_image_system' => '/images/systems/',
    'search_key' => [
        'search_type_key' => 'search_type',
        'search_text_key' => 'search_text',
    ],
    'sort' => [
        'increasing' => 'asc',
        'descending' => 'desc',
    ],
    'user' => [
        'max_length_name' => 50,
        'max_length_password' => 60,
        'max_capacity_avatar' => 4000,
        'avatar_url' => '/images/avatars/',
        'avatar_name_default' => 'default-avatar.png',
        'user_record_default' => 10,
    ],
    'subject' => [
        'max_length_name' => 20,
        'subject_record_default' => 10,
    ],
    'question' => [
        'type_question' => [
            'single_choice' => 1,
            'multiple_choice' => 2,
            'text' => 3,
        ],
        'max_length_content' => 255,
        'question_record_default' => 20,
    ],
];

<?php

return [
    'path_image_system' => '/images/systems/',
    'menu' => [
        'menu_default' => 'home',
        'menu_user' => 'user',
        'menu_subject' => 'subject',
        'menu_question' => 'question',
        'menu_question_answer' => 'question_answer',
        'menu_exam' => 'exam',
        'menu_suggestion' => 'suggestion',
        'menu_profile' => 'profile',
    ],
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
    'question_answer' => [
        'max_length_content' => 255,
        'correct' => [
            'answer_true' => 1,
            'answer_false' => 0,
        ],
        'question_answer_record_default' => 20,
    ],
    'suggestion' => [
        'suggestion_record_default' => 10,
        'status' => [
            'waiting' => 1,
            'confirm' => 2,
        ],
    ],
    'number_random_token_password_reset' => 40,
];

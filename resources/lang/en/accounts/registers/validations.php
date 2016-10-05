<?php

return [
    'name' => [
        'required' => 'Please enter name to register',
        'max' => 'Name of user is maximum 50 characters',
    ],
    'email' => [
        'required' => 'Please enter email to register',
        'email' => 'Email invalid. Please enter again!',
        'unique' => 'Email is exist in system. Please enter again!',
    ],
    'chatwork_id' => [
        'required' => 'Please enter chatwork_id to register',
    ],
    'password' => [
        'required' => 'Please enter password to register',
        'confirmed' => 'Password confirm incorrect. Please check again!',
        'max' => 'Password is maximum 50 characters',
    ],
    'avatar' => [
        'file' => 'This avatar not uploaded on server. Please upload again!',
        'image' => 'File is not image(.jpeg, .png, .bmp, .gif, or .svg).Please upload again!',
        'max' => 'Size of avatar is maximum 4MB',
    ],
];

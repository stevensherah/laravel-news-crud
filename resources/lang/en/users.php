<?php

return [
    'form_inputs' => [
        'name' => 'First Name',
        'email' => 'Your Email',
        'password' => 'Password',
        'password_confirmation' => 'Repeat Password',
        'remember' => 'Remember Me',
    ],

    'validate_messages' => [
        'name' => [
            'required' => trans('validation.required', ['attribute' => 'First Name']),
            'max' => [
                'string' => Lang::get('validation.max.string', ['attribute' => 'First Name', 'max' => 255]),
            ],
        ],
        'email' => [
            'email' => trans('validation.email', ['attribute' => 'Your Email']),
            'required' => trans('validation.required', ['attribute' => 'Your Email']),
            'min' => [
                'string' => Lang::get('validation.min.string', ['attribute' => 'Your Email', 'min' => 6]),
            ],
            'max' => [
                'string' => Lang::get('validation.max.string', ['attribute' => 'Your Email', 'max' => 50]),
            ],
        ],
    ],

    'register' => [
        'meta'=> [
            'title'=> 'Register New User | NewsCrud'
        ],
        'breadcrumb'=> 'Register',
        'name' => 'Register',
        'btn_submit_register' => 'Confirm',
    ],
    'login' => [
        'meta'=> [
            'title'=> 'Authorization | NewsCrud'
        ],
        'breadcrumb'=> 'Login',
        'name' => 'Authorization',
        'btn_submit_login' => 'Login',
    ],

    'index'=> [
        'meta'=> [
            'title'=> 'All Users | NewsCrud'
        ],
        'breadcrumb'=> 'All Users',
        'name'=> 'All Users List',
    ],

    'show'=> [
        'meta'=> [
            'title'=> ':Name | Profile Page | NewsCrud'
        ],
        'breadcrumb'=> 'Profile: :Name',
        'posts_count'=> 'Published News',
        'comments_count'=> 'Comments'
    ],

];

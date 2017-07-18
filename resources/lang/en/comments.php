<?php

return [
    'box' => [
        'latest' => [
            'title' => 'Discuss'
        ],
    ],
    'form_add' => [
        'title' => 'Add Comment',
        'btn_submit_add' => 'Save',
        'inputs' => [
            'name' => 'Your First Name',
            'email' => 'Your Email',
            'content' => 'Comment',
        ],
    ],
    'index'=>[
        'meta'=> [
            'title'=> 'All Comments | NewsCrud',
            'title_user'=> 'Comments of :Name | NewsCrud',
        ],
        'breadcrumb'=> 'All Comments',
        'name_all'=> 'All Comments',
        'name_user'=> 'Comments of :Name',
    ],
    'result_is_empty'=> 'Not found any comments',
    'validate_messages' => [

        'create' => [
            'post_id' => 'News ID',
            'user_id' => 'User ID',
            'name' => 'Your Name',
            'email' => 'Your Email',
            'name_and_email' => 'Your Name and Email',
            'content' => 'Comment',
        ],

        'latest' => [
            'limit' => 'Limit',
        ],

        'index'=> [
            'page' => 'Page Number',
            'limit' => 'Limit',
            'post_id' => 'News ID',
            'user_id' => 'User ID',
        ],
    ],
];

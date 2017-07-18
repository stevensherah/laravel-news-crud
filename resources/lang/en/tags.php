<?php

return [
    'box' => [
        'title' => 'Tags',
    ],

    'index' => [
        'meta' => [
            'title' => 'All Tags | NewsCrud'
        ],
        'breadcrumb' => 'All Tags',
        'name' => 'All Tags List',
        'tags_is_empty' => 'The tags list is empty.'
    ],

    'show' => [
        'meta' => [
            'title' => ':Tag | NewsCrud'
        ],
        'breadcrumb' => 'Tag: :Tag',
        'name' => 'News By Tag: :Tag',
    ],

    'validate_messages' => [
        'show' => [
            'page' => 'Page Number',
            'limit' => 'Limit',
            'category_id' => 'Category ID',
            'user_id' => 'Author ID',
            'tag' => 'Tag',
        ],
    ],
];

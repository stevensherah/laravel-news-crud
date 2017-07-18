<?php

return [
    'box' => [
        'popular' => [
            'title' => 'News'
        ],
        'latest' => [
            'title' => 'News'
        ],
    ],

    'index'=> [
        'meta'=> [
            'title'=> 'All News | NewsCrud',
        ],
        'breadcrumb'=> 'All News',
        'name'=> 'All News List',
        'btn_post_create' => 'Add News',
        'btn_post_edit' => 'Edit',
        'btn_post_delete' => 'Delete',
        'tag_title' => 'Tag',
    ],

    'create'=> [
        'meta'=> [
            'title'=> 'Create News | NewsCrud',
        ],
        'breadcrumb'=> 'Create',
        'name'=> 'Create News',
        'btn_submit_create' => 'Create',
        'messages' => [
            'access_denied'=> 'Access Denied. News create can only authorized users.',
        ],
    ],

    'store'=> [
        'messages' => [
            'success'=> 'News Successfully Created'
        ],
    ],

    'show'=> [
        'category' => 'Category',
        'author' => 'Author',
        'block_comments_title'=> 'Comments',
    ],

    'edit'=> [
        'meta'=> [
            'title'=> 'Edit News | NewsCrud',
        ],
        'breadcrumb'=> 'Edit',
        'name'=> 'Edit News',
        'created_at' => 'Created',
        'updated_at' => 'Edited',
        'btn_submit_edit' => 'Confirm',
        'messages' => [
            'access_denied'=> 'Access Denied. News edit can only authorized users.',
        ],
    ],

    'update'=> [
        'messages' => [
            'success'=> 'News Successfully Updated'
        ],
    ],

    'modal_confirm_delete' => [
        'title' => 'Delete this post?',
        'btn_delete' => 'Confirm',
        'btn_close' => 'Close',
    ],
    'result_is_empty' => 'News is not found',
    'option_select' => 'Select',
    'manage_form' => [
        'published_at' => 'Publish',
        'published_now' => 'Publish Now',
        'category_id' => 'Category',
        'slug' => 'Slug',
        'tags' => 'Tags',

        'title' => 'Meta Title',
        'description' => 'Meta Description',
        'keywords' => 'Meta Keywords',
        'name' => 'Heading',
        'summary' => 'Summary',
        'story' => 'Story',
    ],

    'validate_messages' => [
        'index' => [
            'page' => 'Page Number',
            'limit' => 'Limit',
            'category_id' => 'Category ID',
            'user_id' => 'Author ID',
            'tag' => 'Tag',
        ],

        'create' => [
            'user_id' => 'User ID',
            'published_at' => 'Publish',
            'published_now' => 'Publish Now',
            'category_id' => 'Category',
            'slug' => 'Slug',
            'tags' => 'Tags',
            'title' => 'Meta Title',
            'description' => 'Meta Description',
            'keywords' => 'Meta Keywords',
            'name' => 'Heading',
            'summary' => 'Summary',
            'story' => 'Story',
        ],

        'update' => [
            'id' => 'News ID',
        ],

        'delete' => [
            'id' => 'News ID',
        ],

        'comments_loop' => [
            'commentPage' => 'Comment Page Number',
        ],
    ],
];

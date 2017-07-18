<?php

return [
    'index' => [
        'meta'=> [
            'title' => 'Categories Manage',
        ],
        'breadcrumb'=> 'Categories',
        'name'=> 'Categories Manage',
        'btn_category_create' => 'Create Category',
        'btn_category_edit' => 'Edit',
        'btn_category_delete' => 'Delete',
        'table_columns' => [
            'name' => 'Name',
            'slug' => 'Slug',
            'active' => 'Active',
        ],
        'active_status_yes' => 'YES',
        'active_status_no' => 'NO',
    ],
    'create' => [
        'meta'=> [
            'title' => 'Create Category',
        ],
        'breadcrumb'=> 'Create',
        'name' => 'Create Category',
        'btn_submit_create' => 'Create',
    ],
    'store'=> [
        'messages' => [
            'success_created'=> 'Category success created'
        ],
    ],
    'show'=> [
        'meta'=> [
            'title'=> ':Category | News List | NewsCrud'
        ],
    ],
    'edit' => [
        'meta'=> [
            'title' => 'Edit Category',
        ],
        'breadcrumb'=> 'Edit',
        'name' => 'Edit Category — :Name',
        'btn_submit_edit' => 'Confirm',
    ],
    'update'=> [
        'messages' => [
            'success_updated'=> 'Category success updated'
        ],
    ],
    'manage_form' => [
        'slug' => 'Slug',
        'name' => 'Name',
        'active' => 'Activate',
    ],
    'validate_messages' => [
        'create' => [
            'active' => 'Activate',
            'slug' => 'Slug',
            'name' => 'Name',
        ],
        'update' => [
            'id' => 'Category ID',
        ],
        'delete' => [
            'id' => 'Category ID',
        ],
    ],
];
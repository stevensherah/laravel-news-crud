<?php


Route::group(['namespace' => 'v1', 'prefix' => 'v1'], function (){

    Route::group(['prefix' => 'post'], function (){

        Route::post('pagination-news',
            ['as' => 'api.post.paginate.news', 'uses' => 'PostController@paginationNews']);

        Route::post('pagination-category',
            ['as' => 'api.post.paginate.category', 'uses' => 'PostController@paginationCategory']);

        Route::post('pagination-tags', ['as' => 'api.post.paginate.tags', 'uses' => 'PostController@paginationTags']);

        Route::post('pagination', ['as' => 'api.post.paginate', 'uses' => 'PostController@pagination']);

        Route::post('destroy', ['as' => 'api.post.destroy', 'uses' => 'PostController@destroy']);

        Route::post('comment/add', ['as' => 'api.post.comment.add', 'uses' => 'CommentController@store']);

        Route::post('comments/latest', ['as' => 'api.post.comments.latest', 'uses' => 'CommentController@latest']);
    });


    Route::post('comments', ['as' => 'api.comments.paginate', 'uses' => 'CommentController@latest']);

    Route::post('category/destroy', ['as' => 'api.category.delete', 'uses' => 'CategoryController@destroy']);
});

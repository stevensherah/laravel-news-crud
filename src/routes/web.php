<?php

Route::get('/', ['as' => 'home', 'uses' => 'MainController']);
Route::get('home', function () {
    return redirect()->route('home');
});

Route::get('register', ['as' => 'register.create', 'uses' => 'RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'register.store', 'uses' => 'RegisterController@register']);

Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);


Route::resource('tags', 'TagController', ['only' => ['index', 'show']]);
Route::resource('category', 'CategoryController', ['except' => 'destroy']);

Route::resource('news', 'PostController', ['except' => ['show', 'edit', 'destroy']]);
Route::get('news/{id}-{slug}', ['as' => 'news.show', 'uses' => 'PostController@show']);
Route::get('news/{id}-{slug}/edit', ['as' => 'news.edit', 'uses' => 'PostController@edit']);

Route::resource('comments', 'CommentController', ['only' => 'index']);
Route::resource('user', 'UserController', ['only' => ['index', 'show']]);

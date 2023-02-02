<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//posts
Route::prefix('posts')->group(function (){
    Route::get('/', 'PostController@index');
    Route::post('/create', 'PostController@store');
    Route::get('/edit/{id}', 'PostController@edit');
    Route::put('/update/{id}', 'PostController@update');
    Route::delete('/delete/{id}', 'PostController@delete');
    Route::get('/search/{data}', 'PostController@search');

});

//tag
Route::prefix('tag')->group(function (){
    Route::get('/', 'TagController@index');
    Route::post('/create', 'TagController@store');
    Route::get('/edit/{id}', 'TagController@edit');
    Route::put('/update/{id}', 'TagController@update');
    Route::delete('/delete/{id}', 'TagController@delete');
});



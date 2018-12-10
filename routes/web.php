<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Blog@index');
Route::get('/article/{slug}', 'Blog@showArticle');

Route::post('/comment/{article_id}', 'Blog@comment');
Route::post('/subcomment/{comment_id}/{article_id}', 'Blog@subcomment');

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('post' , 'PostController');

Route::get('summernote',array('as'=>'summernote.get','uses'=>'PostController@getSummernote'));

Route::post('summernote',array('as'=>'summernote.post','uses'=>'PostController@postSummernote'));

Route::post('/comment/{id}','CommentController@storecomment');

Route::post('/tag','TagController@store');
Route::get('/post/tag/{tag}','TagController@index');



Route::get('/admin','AdminPanelController@indexuser');

//admin panel Route
Route::post('/{id}/indexstore','AdminPanelController@indexstore');
Route::get('/{id}/showposts','AdminPanelController@showposts');
Route::delete('user/{id}/','AdminPanelController@destroyuser');


///session route
Route::put('/{id}/session','PostController@session');
Route::get('/showbaskets','PostController@showbasket');
Route::post('/checkout','PostController@checkout')->middleware('auth');
Route::get('/showshops','PostController@showshops');
Route::get('/reducebyone/{id}','PostController@reducebyone');
Route::get('/reducebyone/{id}','PostController@reducebyone');
Route::get('/removeshop/{id}','PostController@removeshop');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

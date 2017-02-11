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

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/now', function(){
    return date("Y-m-d H:i:s");
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@index');
    Route::resource('article','ArticleController');
});

Route::resource('photo', 'PhotoController');



//builder routing
Route::group(['middleware' => 'auth', 'namespace' => 'Worldbuilder', 'prefix' => 'worldbuilder'], function(){
    Route::post('/', 'HomeController@store');
    Route::get('/build', 'BuildController@index');
    Route::post('/build','BuildController@store');
});

Route::group(['namespace' => 'Forms','prefix' => 'forms'], function () {
    Route::get('/FormName', 'FormNameController@index');
    Route::post('/FormName', 'FormNameController@store');
});

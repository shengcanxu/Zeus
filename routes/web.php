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



Route::group(['prefix' => 'form_name'], function () {

    Route::get('/',         ['as' => 'form_name.index',    'uses' => 'Form_NameController@index']);
    Route::get('/{id}',     ['as' => 'form_name.show',     'uses' => 'Form_NameController@show']);
    Route::get('/{id}/edit',['as' => 'form_name.edit',     'uses' => 'Form_NameController@edit']);
    Route::post('/update',  ['as' => 'form_name.update',   'uses' => 'Form_NameController@update']);
    Route::get('/create',   ['as' => 'form_name.create',   'uses' => 'Form_NameController@create']);
    Route::get('/store',    ['as' => 'form_name.store',    'uses' => 'Form_NameController@store']);

});




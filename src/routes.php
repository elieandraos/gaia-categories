<?php
/*
|--------------------------------------------------------------------------
| News Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::model('category', 'App\Models\Category');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
{
   Route::get('/categories', ['as' => 'admin.categories.list', 'uses' => 'Gaia\Categories\CategoryController@index']);
   Route::post('/categories/store', ['as' => 'admin.categories.store', 'uses' => 'Gaia\Categories\CategoryController@store']);   
   Route::get('/categories/{category}/edit', ['as' => 'admin.categories.edit', 'uses' => 'Gaia\Categories\CategoryController@edit']);
   Route::post('/categories/{category}/update', ['as' => 'admin.categories.update', 'uses' => 'Gaia\Categories\CategoryController@update']);
   Route::post('/categories/{category}/delete', ['as' => 'admin.categories.delete', 'uses' => 'Gaia\Categories\CategoryController@destroy']);
   Route::get('/categories/{category}/translate/{locale}', ['as' => 'admin.categories.translate', 'uses' => 'Gaia\Categories\CategoryController@translate']);
   Route::post('/categories/{category}/translate/{locale}/store', ['as' => 'admin.categories.translate-store', 'uses' => 'Gaia\Categories\CategoryController@translateStore']);
   Route::post('/categories/sort', [ 'as' => 'admin.categories.sort' ,'uses' => 'Gaia\Categories\CategoryController@sort']);
});
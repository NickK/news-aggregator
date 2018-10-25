<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('settings/tags', 'API\TagsController@index')->name('api/settings/tags');
Route::post('settings/tags/create', 'API\TagsController@create')->name('api/settings/tags/create');
Route::post('settings/tags/remove', 'API\TagsController@destroy')->name('api/settings/tags/remove');

// Sources
Route::get('settings/sources', 'API\SourcesController@index')->name('api/settings/sources');
Route::post('settings/sources/update', 'API\SourcesController@update')->name('api/settings/sources/update');

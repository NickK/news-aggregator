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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/settings', 'SettingsController@dashboard')->name('settings/dashboard');
Route::patch('/settings/update/basic', 'SettingsController@updateBasicInfo')->name('settings/update/basic');

// Delete Account
Route::post('/settings/account/remove', 'AccountController@destroy')->name('settings/account/remove');

// Steps
Route::get('/steps', 'StepsController@index')->name('steps');

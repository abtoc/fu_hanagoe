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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/channels/create', 'ChannelController@create')->name('channel.create');
    Route::post('/channels/store', 'ChannelController@store')->name('channel.store');
    Route::get('/channels/confirm', 'ChannelController@confirm')->name('channel.confirm');
    Route::delete('/channels/{channel}/destroy', 'ChannelController@destroy')->name('channel.destroy');
});

Route::get('/channels', 'ChannelController@index')->name('channel.index');
Route::get('/channels/{channel}', 'ChannelController@show')->name('channel.show');


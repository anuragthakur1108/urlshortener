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

Route::get('/', 'HomeController@home');
//{
//    return view('welcome');
//});

Route::auth();
Route::get('/home', 'HomeController@index');
Route::post('/home/saveData', array('as' => 'saveData', 
    'uses' => 'HomeController@saveData'));
Route::get('/home/delete_url', 'HomeController@delete_url');

Route::get('{slug}', [
    'uses' => 'HomeController@redirectPage' 
])->where('slug', '([A-Za-z0-9\-\/]+)');
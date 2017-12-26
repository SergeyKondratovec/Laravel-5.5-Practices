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


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', "IndexController@index");
Route::post('/search', "IndexController@search");
Route::post('/search/filter', "IndexController@filter");

Route::get('/artisan', function () {

    $exitCode = Artisan::call('sm:elastic', [
        'action'  => 'revert',
        '--index' => 'product',
    ]);
    return $exitCode;
});

/*Route::get('/email', function () {

    \App\Jobs\SendEmail::dispatch();

    return "Add email to queue";
});*/
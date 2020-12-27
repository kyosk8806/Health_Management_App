<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/records/{month}', 'App\Http\Controllers\RecordController@index');
Route::delete('/records/{id}', 'App\Http\Controllers\RecordController@destroy')->name('records.destroy');
Route::get('/records/create', 'App\Http\Controllers\RecordController@create')->name('records.create');
Route::post('/records', 'App\Http\Controllers\RecordController@store')->name('records.store');

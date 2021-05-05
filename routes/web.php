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
Route::get('/{month}/{year}', 'App\Http\Controllers\RecordController@index')->name('records.index');
Route::delete('/records/{id}', 'App\Http\Controllers\RecordController@destroy')->name('records.destroy');
Route::get('/records/create', 'App\Http\Controllers\RecordController@create')->name('records.create');
Route::post('/records', 'App\Http\Controllers\RecordController@store')->name('records.store');
Route::patch('/records/edit/{id}', 'App\Http\Controllers\RecordController@update')->name('records.update');
Route::patch('/records/profile/edit/{id}', 'App\Http\Controllers\RecordController@profileUpdate')->name('records.profileUpdate');
Route::get('/graph/{month}/{year}', 'App\Http\Controllers\GraphController@index')->name('graph.index');
Route::get('/csv/{month}/{year}', 'App\Http\Controllers\Csv@download')->name('csv.index');

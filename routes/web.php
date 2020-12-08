<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/standing', 'StandingController@index')->name('standing.index');
Route::get('/schedule', 'ScheduleController@index')->name('schedule.index');
Route::get('/teams', 'TeamController@index')->name('team.index');

Route::group(['middleware'=>['auth']], function(){
    Route::get('/profile/{id}', 'ProfileController@index')->name('profile.index');
    Route::get('/guess', 'GuessController@index')->name('guess.index');
    Route::get('/guess/table', 'GuessController@tableByMatchday')->name('guess.table.matchday');
    Route::get('/guess/{matchday}', 'GuessController@show')->name('guess.show');
    Route::post('/guess/store/{matchday}', 'GuessController@store')->name('guess.store');
});
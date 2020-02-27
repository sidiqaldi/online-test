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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@homepage')->name('homepage');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::prefix('creator')->name('creator.')->group(function () {
        Route::resource('/exams', 'Creator\ExamController');
        Route::resource('/configs', 'Creator\ConfigController')->only('update');
    });
});

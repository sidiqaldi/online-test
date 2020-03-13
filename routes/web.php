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
        Route::put('/exams-publish/{exam}', 'Creator\ExamController@publish')->name('exams.publish');
        Route::resource('/configs', 'Creator\ConfigController')->only('update');
        Route::prefix('/sections')->group(function () {
            Route::get('/{exam}', 'Creator\SectionController@index')->name('sections.index');
            Route::get('/{exam}/create', 'Creator\SectionController@create')->name('sections.create');
            Route::post('/{exam}/store', 'Creator\SectionController@store')->name('sections.store');
            Route::get('/{section}/edit', 'Creator\SectionController@edit')->name('sections.edit');
            Route::put('/{section}/update', 'Creator\SectionController@update')->name('sections.update');
            Route::post('/{section}/order', 'Creator\SectionController@order')->name('sections.order');
            Route::delete('/{section}', 'Creator\SectionController@destroy')->name('sections.destroy');
        });
        Route::prefix('/questions')->group(function () {
            Route::get('/{section}', 'Creator\QuestionController@index')->name('questions.index');
            Route::get('/{section}/create', 'Creator\QuestionController@create')->name('questions.create');
            Route::post('/{section}/create', 'Creator\QuestionController@store')->name('questions.store');
            Route::get('/{question}/edit', 'Creator\QuestionController@edit')->name('questions.edit');
            Route::put('/{question}/update', 'Creator\QuestionController@update')->name('questions.update');
            Route::post('/{question}/order', 'Creator\QuestionController@order')->name('questions.order');
            Route::delete('/{question}', 'Creator\QuestionController@destroy')->name('questions.destroy');
        });
    });

    Route::prefix('participant')->name('participant.')->group(function () {
        Route::prefix('/exams')->group(function () {
            Route::get('form', 'Participant\ExamController@form')->name('exams.form');
            Route::post('details', 'Participant\ExamController@details')->name('exams.details.post');
            Route::get('details/{code}', 'Participant\ExamController@show')->name('exams.details.show');
            Route::post('join', 'Participant\ExamController@join')->name('exams.join');
        });
        Route::prefix('/results')->group(function () {
            Route::get('/', 'Participant\ResultController@index')->name('results.index');
        });
    });
});

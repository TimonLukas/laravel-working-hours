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
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
});

Auth::routes();

Route::get('/register', function () {
    if (\App\User::count() > 0) {
        return redirect('/home');
    }

    return view('auth.register');
})->name('register');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::resource('/projects', 'ProjectController');
    Route::resource('/works', 'WorkController');
    Route::get('/works/create/start', 'WorkController@createStart');
    Route::get('/works/create/end/{id}', 'WorkController@createEnd');

    Route::group(['middleware' => ['is-manager']], function () {
        Route::resource('/users', 'UserController');
    });
});
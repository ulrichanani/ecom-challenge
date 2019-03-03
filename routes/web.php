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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * ADMIN ROUTES
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::namespace('Admin')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        // Departments
        Route::get('/departments/list', 'DepartmentsController@list')->name('departments.list');
        Route::resource('/departments', 'DepartmentsController')->except(['create', 'edit']);

        // Categories
        Route::get('/departments/{department}/categories/list', 'CategoriesController@list')
            ->name('departments.categories.list');
        Route::resource('departments.categories', 'CategoriesController')->except(['create', 'edit']);

        // Attributes
        Route::get('/attributes/list', 'AttributesController@list')->name('attributes.list');
        Route::resource('/attributes', 'AttributesController')->except(['create', 'edit']);

        // Attributes values
        Route::get('/attributes/{attribute}/values/list', 'AttributeValuesController@list')
            ->name('attributes.values.list');
        Route::resource('attributes.values', 'AttributeValuesController')->except(['create', 'edit']);
    });
});

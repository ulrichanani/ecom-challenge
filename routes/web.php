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


Route::group(['middleware' => 'shopping_cart'], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');

    // User
    Route::get('/user', 'UserController@index')->name('user');
    Route::put('/user', 'UserController@update')->name('user.update');

    // Product
    Route::get('/search', 'ProductsController@search')->name('search');
    Route::post('products/{product}/reviews', 'ProductsController@addReview')->name('products.addReview');
    Route::resource('products', 'ProductsController')->only(['index', 'show']);

    Route::group(['middleware' => 'products_page'], function () {
        Route::resource('departments', 'DepartmentsController')->only(['index', 'show']);
        Route::resource('categories', 'CategoriesController')->only(['index', 'show']);
    });

    // Cart
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::put('/cart', 'CartController@update')->name('cart.update');
    Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware('auth');
    Route::post('/place-order', 'CartController@order')->name('order')->middleware('auth');
    Route::post('/cart/add-item/{product}', 'CartController@addItem')->name('cart.add-item');
    Route::post('/cart/save-for-later/{item}', 'CartController@saveForLater')->name('cart.save-for-later');
    Route::post('/cart/move-to-cart/{item}', 'CartController@moveToCart')->name('cart.move-to-cart');
    Route::delete('/cart/remove-item/{item}', 'CartController@removeItem')->name('cart.remove-item');
});

/**
 * ADMIN ROUTES
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::namespace('Admin')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        // Departments
        Route::get('/departments/{department}/categories/list', 'CategoriesController@list')
            ->name('departments.categories.list');
        Route::get('/departments/list', 'DepartmentsController@list')->name('departments.list');
        Route::resource('/departments', 'DepartmentsController')->except(['create', 'edit']);

        // Categories
        Route::get('/categories/{category}/products/list', 'CategoriesController@productsList')
            ->name('categories.products.list');
        Route::get('categories/{category}/products', 'CategoriesController@products')
            ->name('categories.products');
        Route::get('/categories/all', 'CategoriesController@all');
        Route::get('/categories/{category}', 'CategoriesController@show');
        Route::put('/categories/{category}', 'CategoriesController@update');
        Route::delete('/categories/{category}', 'CategoriesController@destroy');
        Route::resource('departments.categories', 'CategoriesController')->only(['index', 'store']);

        // Attributes
        Route::get('/attributes/list', 'AttributesController@list')->name('attributes.list');
        Route::resource('/attributes', 'AttributesController')->except(['create', 'edit']);

        // Attributes values
        Route::get('/attributes-values', 'AttributeValuesController@all');
        Route::get('/attributes/{attribute}/values/list', 'AttributeValuesController@list')
            ->name('attributes.values.list');
        Route::resource('attributes.values', 'AttributeValuesController')->except(['create', 'edit']);

        // Products
        Route::get('products/list', 'ProductsController@list')->name('products.list');
        Route::resource('products', 'ProductsController');
    });
});

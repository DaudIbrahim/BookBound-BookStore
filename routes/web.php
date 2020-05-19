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

/**
 * Customized Auth Routes
 * Disabling options to reset and verify
 * ReferenceWeb - https://stackoverflow.com/a/29183435/7031530
 */
Auth::routes([
    'register' => true,
    'reset' => false,
    'verify' => false,
]);

/**
 * Guest Routes. (Routes for All).
 */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/books', 'BookController@index')->name('books.index');
Route::get('/books/{book}/details', 'BookController@details')->name('books.details');


/**
 * Admin Routes.
 */
Route::group(['prefix' => 'administrator', "as" => "admin."], function () {
    Route::get('/', 'AdminHomeController@index');
    Route::get('/home', 'AdminHomeController@index')->name('home');

    // Books (Following Resource Controller Convention ✔)
    Route::get('/books', 'AdminBookController@index')->name('books.index'); #1 Index
    Route::get('/books/search', 'AdminBookController@search')->name('books.search');
    Route::get('/books/create', 'AdminBookController@create')->name('books.create'); #2 Create
    Route::post('/books', 'AdminBookController@store')->name('books.store'); #3 Store
    Route::get('/books/{book}', 'AdminBookController@show')->name('books.show'); #4 Show
    Route::get('/books/{book}/edit', 'AdminBookController@edit')->name('books.edit'); #5 Edit
    Route::put('/books/{book}', 'AdminBookController@update')->name('books.update'); #6 Update

    // Catgories (Following Resource Controller Convention)
    Route::get('/categories', 'AdminCategoryController@index')->name('categories.index');
    Route::get('/categories/create', 'AdminCategoryController@create')->name('categories.create');
    Route::post('/categories', 'AdminCategoryController@store')->name('categories.store');
    Route::get('/categories/{category}', 'AdminCategoryController@show')->name('categories.show');
    Route::get('/categories/{category}/edit', 'AdminCategoryController@edit')->name('categories.edit');
    Route::put('/categories/{category}', 'AdminCategoryController@update')->name('categories.update');
    # Bad Naming Scheme categories.fetch actually fetches it's own subcategories 
    Route::get('/categories/{category}/fetch', 'AdminCategoryController@fetch')->name('categories.fetch');

    // Subcatgories (Following Resource Controller Convention)
    Route::get('/subcategories', 'AdminSubcategoryController@index')->name('subcategories.index');
    Route::get('/subcategories/create', 'AdminSubcategoryController@create')->name('subcategories.create');
    Route::post('/subcategories', 'AdminSubcategoryController@store')->name('subcategories.store');
    Route::get('/subcategories/{subcategory}', 'AdminSubcategoryController@show')->name('subcategories.show');
    Route::get('/subcategories/{subcategory}/edit', 'AdminSubcategoryController@edit')->name('subcategories.edit');
    Route::put('/subcategories/{subcategory}', 'AdminSubcategoryController@update')->name('subcategories.update');

    // Area (Following Resource Controller Convention)
    Route::get('/areas', 'AdminAreaController@index')->name('areas.index');
    Route::get('/areas/create', 'AdminAreaController@create')->name('areas.create');
    Route::post('/areas', 'AdminAreaController@store')->name('areas.store');
    Route::get('/areas/{area}', 'AdminAreaController@show')->name('areas.show');
    Route::get('/areas/{area}/edit', 'AdminAreaController@edit')->name('areas.edit');
    Route::put('/areas/{area}', 'AdminAreaController@update')->name('areas.update');

});

/**
 * Test Routes for Development Purpose
 */
Route::get('/test', 'TestController@index');
Route::get('/test/api/{boolean?}', 'TestController@api');

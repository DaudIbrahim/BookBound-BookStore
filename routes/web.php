
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

// At logout | Get Request | Throws Error | Now Redirect
Route::get('/logout', function() {return redirect()->route('home');} );

// Home (Index)
Route::get('/', 'BookController@index');
Route::get('/home', 'BookController@index')->name('home');

// Books
Route::get('/books', 'BookController@index')->name('books.index');
Route::get('/books/{book}/details', 'BookController@details')->name('books.details');

// Cart
Route::get('/cart/{row?}', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::patch('/cart/{row}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{row}', 'CartController@destroy')->name('cart.destroy');

// Coupon
Route::get('/coupon/apply', 'CouponController@apply')->name('coupon.apply');
Route::get('/coupon/remove', 'CouponController@remove')->name('coupon.remove');

/**
 * Customer Logged In Routes
 * Requires Customers to be logged in 
 */
// Checkout
Route::get('/checkout', 'CustomerCheckoutController@index')->name('checkout.index');
Route::post('/checkout', 'CustomerCheckoutController@store')->name('checkout.store');

// Orders
Route::get('/orders', 'CustomerOrderController@index')->name('orders.index');
Route::get('/orders/{order}', 'CustomerOrderController@show')->name('orders.show');

// Reviews (Store)
Route::get('/reviews', 'CustomerReviewController@index')->name('reviews.index');
Route::post('/reviews', 'CustomerReviewController@store')->name('reviews.store');

/**
 * Admin Routes.
 */
Route::group(['prefix' => 'administrator', "as" => "admin."], function () {
    Route::get('/', 'AdminHomeController@index');
    Route::get('/home', 'AdminHomeController@index')->name('home');

    // Books (Following Resource Controller Convention ✔)
    Route::get('/books', 'AdminBookController@index')->name('books.index'); #1 Index
    Route::get('/books/search', 'AdminBookController@search')->name('books.search');

    Route::get('/books/search/title', 'AdminBookController@searchByTitle')->name('books.search.title');

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

    // Coupon
    Route::get('/coupons', 'AdminCouponController@index')->name('coupons.index');
    Route::get('/coupons/create', 'AdminCouponController@create')->name('coupons.create');
    Route::get('/coupons/fetch/code', 'AdminCouponController@code')->name('coupons.code');
    Route::post('/coupons', 'AdminCouponController@store')->name('coupons.store');
    Route::get('/coupons/{coupons}', 'AdminCouponController@show')->name('coupons.show');

    /**
     * 1 - index()
     * 2 - create()
     * 3 - store()
     * 4 - show()
     * 5 - edit()
     * 6 - update()
     * 7 - destroy()
     */
    // Orders
    Route::get('/orders','AdminOrderController@index')->name('orders.index');
    Route::get('/orders/{order}','AdminOrderController@show')->name('orders.show');
    Route::get('/orders/{order}/edit','AdminOrderController@edit')->name('orders.edit');
    Route::put('/orders/{order}','AdminOrderController@update')->name('orders.update');

    // Route::get('/orders/stock/{stock}', 'AdminOrderController@stock')->name('orders.stock'); #Unused

});

/**
 * Test Routes for Development Purpose
 */
Route::get('/test', 'TestController@index');
Route::get('/test/api/{boolean?}', 'TestController@api');

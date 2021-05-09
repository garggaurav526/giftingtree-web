<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::prefix('auth')->group(function(){
 
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
 
    });
 
    Route::group([
        'middleware'=>'auth:api'
    ], function(){
        
        // user
        Route::get('user', 'AuthController@getUser');
        Route::post('user-update', 'AuthController@updateProfile');

        Route::get('helloworld', 'AuthController@index');
        Route::post('logout', 'AuthController@logout');
        Route::post('update-password', 'AuthController@updatePassword');
        Route::post('forget-password', 'AuthController@requestChangePassword');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('admin-user-update', 'AuthController@updateUserProfile');
        Route::post('update-user-update', 'AuthController@changeUserPassword');
        // Wishlist apis
        Route::get('wishlist', 'CommonController@getWishlist');
        Route::get('wishlist/{id}', 'CommonController@getWishlistById');
        Route::delete('wishlist/{id}', 'CommonController@deleteWishlist');
        Route::post('wishlist/add', 'CommonController@createWishlist');
        // Rating apis
        Route::get('rating', 'CommonController@getRatings');
        Route::get('rating-distinct', 'CommonController@getDistincRating');
        Route::get('ratings', 'CommonController@getAllRatings');
        Route::get('rating/{id}', 'CommonController@getRatingById');
        Route::delete('rating/{id}', 'CommonController@deleteRating');
        Route::post('rating/add', 'CommonController@createRating');
        // Categories api
        Route::get('categories', 'CategoriesController@getCategories');
        Route::get('categories-all', 'CategoriesController@getCategoriesAll');
        Route::get('categories-sub-all', 'CategoriesController@getCategoriesSubAll');
        Route::get('sub-categories/{category_id}', 'CategoriesController@getSubCategories');
        Route::get('categories-item/{category_id}', 'CategoriesController@getCategoryItem');
        Route::get('category/{id}', 'CategoriesController@getCategoriesById');
        Route::post('category/update/{id}', 'CategoriesController@updateCategory');
        Route::delete('category/delete/{id}', 'CategoriesController@deleteCategory');
        Route::post('category/create', 'CategoriesController@createCategory');
        // Products api
        Route::get('products', 'ProductsController@getProducts');
        Route::get('product/{id}', 'ProductsController@getProductById');
        Route::post('product/update/{id}', 'ProductsController@updateProduct');
        Route::delete('product/delete/{id}', 'ProductsController@deleteProduct');
        Route::post('product/create', 'ProductsController@createProduct');
        // Orders Api
        Route::get('orders', 'OrdersController@getOrders');
        Route::get('order/{id}', 'OrdersController@getOrderById');
        Route::post('product/update/{id}', 'OrdersController@updateProduct');
        Route::delete('order/delete/{id}', 'OrdersController@deleteOrder');
        Route::post('product/create', 'OrdersController@createProduct');
        // Address api
        Route::get('addresses', 'AddressController@getAddress');
 		Route::get('user-address', 'AddressController@getUserAddress');
        Route::get('address/{id}', 'AddressController@getAddressById');
        Route::post('address/update/{id}', 'AddressController@updateAddress');
        Route::delete('address/delete/{id}', 'AddressController@deleteAddress');
        Route::post('address/create/{uid}', 'AddressController@createAddress');

    });
 

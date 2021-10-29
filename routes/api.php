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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
});
Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('user', 'AddressController@index');
    Route::post('user/address', 'AddressController@store');
    Route::delete('user/address/{id}', 'AddressController@destroy');
    Route::put('user/address/{id}', 'AddressController@update');

    Route::post('checkout', 'OrderController@store');
    Route::get('user/orders', 'OrderController@getorder');
});
Route::get('home','HomeController@index');
Route::get('home/populer/{slug}','HomeController@showPopuler');
Route::post('addcategories','CategoryController@store');
Route::post('carousel/upload','CategoryController@addcarousel');
Route::get('carousel','CarouselController@index');
Route::get('products','ProductController@allProduct');
Route::get('products/{slug}','ProductController@getproducts');
Route::get('products/{slug}/related','ProductController@getproductsrelated');
Route::get('subcategories','SubCategoryController@index');
Route::get('expeditions','ExpeditionController@index');
Route::get('province','AddressController@getprovince');
Route::get('district','AddressController@getdistrict');
Route::get('ongkir','AddressController@get_ongkir');
Route::get('payment','PaymentController@index');
Route::patch('uploadpayment/{id}', 'OrderController@uploadImage');

Route::get('mix-and-match/items','ProductController@getMixAndMatch');

Route::get('cart','CartController@index');
Route::post('cart','CartController@store');
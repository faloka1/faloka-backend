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
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');
});
Route::get('home','HomeController@index');
Route::get('home/populer/{slug}','HomeController@showPopuler');
Route::post('addcategories','CategoryController@store');
Route::post('carousel/upload','CategoryController@addcarousel');
Route::get('carousel','CarouselController@index');
Route::get('products','ProductController@allProduct');
Route::get('products/{slug}','ProductController@getproducts');
Route::get('subcategories','SubCategoryController@index');

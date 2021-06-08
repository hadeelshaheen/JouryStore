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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'jourystore'
], function () {
    Route::post('user/login', [\App\Http\Controllers\Api\AuthController::class,'login']);
    Route::post('user/signup', [\App\Http\Controllers\Api\AuthController::class,'signup']);
    Route::post('user/forgot', [\App\Http\Controllers\Api\ForgotController::class,'forgot']);
    Route::post('user/reset', [\App\Http\Controllers\Api\ForgotController::class,'reset']);

    Route::get('constants', [\App\Http\Controllers\Api\GeneralController::class,'constants']);
    Route::post('constants/add', [\App\Http\Controllers\Api\GeneralController::class,'addconstants']);
    Route::delete('constants/delete/{id}', [\App\Http\Controllers\Api\GeneralController::class,'deleteconstants']);
    Route::post('ads/add', [\App\Http\Controllers\Api\GeneralController::class,'addAds']);

    Route::get('category',  [\App\Http\Controllers\Api\CategoryController::class,'index']);

    Route::post('product/list', [\App\Http\Controllers\Api\ProductController::class,'listProducts']);
    Route::get('offers/list', [\App\Http\Controllers\Api\ProductController::class,'listOffers']);
    Route::post('product/similar',  [\App\Http\Controllers\Api\ProductController::class,'similarProduct']);

    Route::get('home', [\App\Http\Controllers\Api\GeneralController::class,'homeContent']);


    /**/
    Route::post('category',  [\App\Http\Controllers\Api\CategoryController::class,'store']);
    Route::delete('category/{id}',  [\App\Http\Controllers\Api\CategoryController::class,'destroy']);

    Route::post('product',  [\App\Http\Controllers\Api\ProductController::class,'store']);
    Route::delete('product/delete/{id}',  [\App\Http\Controllers\Api\ProductController::class,'destroy']);


    Route::delete('order/delete/{id}',  [\App\Http\Controllers\Api\OrderController::class,'destroy']);
    Route::post('order/update/{id}',  [\App\Http\Controllers\Api\OrderController::class,'update']);



    /**/

    Route::group([
        'middleware' => ['auth:api','changeLanguage']
    ], function() {
        Route::get('user/logout', [\App\Http\Controllers\Api\AuthController::class,'logout']);
        Route::get('user/profile',  [\App\Http\Controllers\Api\AuthController::class,'userProfile']);
        Route::post('user/edit',  [\App\Http\Controllers\Api\AuthController::class,'updateProfile']);


        Route::post('product/search',  [\App\Http\Controllers\Api\ProductController::class,'search']);
        Route::post('product/filter',  [\App\Http\Controllers\Api\ProductController::class,'filter']);



        Route::post('favorite/add',  [\App\Http\Controllers\Api\FavoriteController::class,'store']);
        Route::get('favorite/show',  [\App\Http\Controllers\Api\FavoriteController::class,'index']);
        Route::delete('favorite/delete',  [\App\Http\Controllers\Api\FavoriteController::class,'destroy']);

        Route::get('cart/show',  [\App\Http\Controllers\Api\CartController::class,'index']);
        Route::post('cart/add ',  [\App\Http\Controllers\Api\CartController::class,'store']);
//        Route::post('add/qauntity/{cart_id}',  [\App\Http\Controllers\Api\CartController::class,'update']);
        Route::delete('cart/delete',  [\App\Http\Controllers\Api\CartController::class,'destroy']);

        Route::get('order/show',  [\App\Http\Controllers\Api\OrderController::class,'index']);
        Route::post('order/store',  [\App\Http\Controllers\Api\OrderController::class,'store']);


    });

});

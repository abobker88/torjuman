<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController ;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;



Route::middleware('langApi')->group(function () {
Route::post('user/login', [UserController::class, 'login']);

Route::post('user/register', [UserController::class, 'register']);
Route::any('user/forgot_password', [UserController::class, 'postForgotPassword']);

Route::any('user/change_password', [UserController::class, 'postChangePassword']);
Route::any('reset_password', [UserController::class, 'postResetPassword']);

});
Route::get('/services', [ServiceController::class, 'getAll']);
Route::post('user/signup_with_google', [UserController::class, 'google']);
Route::middleware('AuthApi')->group(function () {
    Route::any('user', [UserController::class, 'userDetails']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::post('order/create', [OrderController::class, 'placeOrder']);
    Route::post('order/create', [OrderController::class, 'placeOrder']);
    Route::get('order/my_order', [OrderController::class, 'getMyOrder']);
    Route::post('user/change_locale', [UserController::class, 'setLocale']);
    Route::get('order/check_order', [OrderController::class, 'checkOrder']);
    Route::post('order/direct_translation', [OrderController::class, 'directTranslation']);
    Route::post('order/sent_to_customer_service', [OrderController::class, 'customerServiceChat']);
    Route::get('order/get_translation_chat', [OrderController::class, 'translatorChat']);
    Route::get('order/get_customer_service_chat', [OrderController::class, 'serviceChat']);
    Route::post('order/sent_to_translator', [OrderController::class, 'sendtoTranslatotChat']);
    Route::get('get_my_notification', [ServiceController::class, 'getUserNotification']);
    Route::get('user/get_remain_words', [ServiceController::class, 'getRemain']);
    Route::post('order/free_trial_service', [OrderController::class, 'freeOrder']);
    Route::post('order/company_service', [OrderController::class, 'companyService']);
    Route::post('order/cancel_order', [OrderController::class, 'cancelOrder']); 
    Route::post('order/change_to_paid', [OrderController::class, 'paid']); 

    
});

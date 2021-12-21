<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('setlocale/{locale}',function($lang){
       \Session::put('locale',$lang);
       \App::setLocale($lang);
      
       return redirect()->back();   
});  



Route::group(['middleware' => 'auth'] , function() {
 /// translator route 
    Route::get('/translator/orders', 'translator\OrderController@index')->name('translator.order');
    Route::get('/translator/orders/accepted', 'translator\OrderController@listAccepted')->name('translator.order.accepted');
    Route::post('/translator/accept_order', 'translator\OrderController@accept')->name('translator.order.accept');
    Route::post('/translator/cancel_order', 'translator\OrderController@cancel')->name('translator.order.cancel');
    Route::post('/translator/download_order', 'translator\OrderController@download')->name('download_order');
    Route::post('/translator/download_translation', 'translator\OrderController@downloadTranslation')->name('download_translation');
    Route::get('/translator/orders/chat/{user_id}/{order_id}', 'translator\OrderController@chat')->name('translator.chat');
    Route::post('/translator/chat/post', 'translator\OrderController@submitChat')->name('translator.chat.post');


    Route::post('/translator/upload/{order_id}', 'translator\OrderController@upload')->name('translator.upload');
    Route::get('/translator/orders/under_check', 'translator\OrderController@listChecked')->name('translator.order.under_check');
    Route::post('/translator/re_upload', 'translator\OrderController@ReUpload')->name('translator.ReUpload');


    
    // checker route
    Route::get('/checker/orders', 'checker\OrderController@listOrder')->name('checker.order');
    Route::post('/checker/approve_order', 'checker\OrderController@approve')->name('checker.order.approve');    
    Route::get('/checker/orders/accepted', 'checker\OrderController@listOrderChecked')->name('checker.approved_order');
    Route::post('/checker/comment', 'checker\OrderController@comment')->name('checker.order.comment');    
    Route::get('/checker/dashboard', 'checker\DashboardController@dashboard')->name('checker.dashboard');

    //customer service 
    Route::get('/customer_service/orders', 'customerService\OrderController@listCancel')->name('customer_service.order.cancel');
    Route::post('/customer_price/update_price', 'customerService\OrderController@updatePrice')->name('customer_service.update_price');
    Route::get('/customer_service/orders/updated', 'customerService\OrderController@listOrderUpdatePrice')->name('customer_service.order.updated_price');
    Route::get('/customer_service/orders/services', 'customerService\OrderController@listOrderSpecialPrice')->name('customer_service.order.services');
    Route::get('/customer_service/operation/orders', 'customerService\OrderController@listOperationOrder')->name('customer_service.order.operation');
    Route::post('/customer_price/operation/update_price', 'customerService\OrderController@updatePriceOperation')->name('customer_service.operation.update_price');
    
    //operation
    Route::get('/operation/orders', 'operation\OrderController@listOrder')->name('operation.order.index');
    Route::post('/operation/accept_order', 'operation\OrderController@accept')->name('operation.order.accept');
    Route::get('/operation/orders/accepted', 'operation\OrderController@listAccepted')->name('operation.order.accepted');
    Route::post('/operation/cancel_order', 'operation\OrderController@cancel')->name('operation.order.cancel');
    Route::get('/operation/check_orders', 'operation\OrderController@listCheckOrder')->name('operation.checker.order');
    Route::post('/operation/upload', 'translator\OrderController@upload')->name('operation.upload');
    Route::get('/operation/orders/complete', 'operation\OrderController@listCompleteOrder')->name('operation.order.complete');
    Route::post('operation/checker/approve_order', 'operation\OrderController@approve')->name('operation.order.approve');   
    Route::get('/operation/orders/chat/{user_id}/{order_id}', 'operation\OrderController@chat')->name('operation.chat');
    Route::post('/operation/chat/post', 'operation\OrderController@submitChat')->name('operation.chat.post');
    Route::get('/operation/dashboard', 'operation\DashboardController@dashboard')->name('operation.dashboard');
    
    //admin 
    Route::get('/admin/dashboard', 'admin\DashboardController@dashboard')->name('admin.dashboard');
    Route::get('/admin/follow_translator', 'admin\DashboardController@translator')->name('admin.translator');
    Route::get('admin/push_notification/create','admin\PushNotificationController@create')->name('admin.push_notification');
    Route::post('admin/push_notification/post', 'admin\PushNotificationController@notifyUser')->name('push_notification.store');   
    Route::get('admin/user/index','admin\UserController@index')->name('admin.user.index');
    Route::post('admin/user/post', 'admin\UserController@store')->name('admin.user.create');   
    Route::post('admin/user/editpost', 'admin\UserController@update')->name('admin.user.edit');   
    Route::post('admin/user/delete', 'admin\UserController@destroy')->name('admin.user.delete');   
    Route::get('admin/chat/index','admin\UserController@chat')->name('admin.chat.index');
    Route::get('/admin/orders/chat/{user_id}/{order_id}', 'admin\UserController@getChat')->name('admin.chat');

    Route::get('/user/profile', 'admin\DashboardController@profile')->name('myProfile');
    Route::post('user/profile/submit', 'admin\DashboardController@submitProfile')->name('profile.store');   


    //accounting
    Route::get('/accounting/dashboard', 'accounting\DashboardController@dashboard')->name('accounting.dashboard');
    Route::get('/accounting/report', 'accounting\DashboardController@report')->name('accounting.report');

    
    
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/register', function() {
    return redirect('/login');    
})->name('login_page');
Route::get('/password/reset', function() {
    return redirect('/login');    
});

Route::get('/', function() {
    return view('torjuman_website.welcome');    
})->name('website.home');;

Route::get('/website/login', function() {
    return view('torjuman_website.login');    
})->name('website.login');

Route::get('/website/register', function() {
    return view('torjuman_website.signup');    
})->name('website.register');

Route::post('user/register/submit', 'website\UserController@register')->name('website.register.post');   


Route::get('/swagger', function() {
    \Artisan::call('l5-swagger:generate');
});

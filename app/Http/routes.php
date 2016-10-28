<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('/requests','DashboardController@getAllRequestsForApp');
Route::get('/requests/promo','DashboardController@getAllPromoRequestsForApp');
Route::get('/update/beurs/{code}','DashboardController@beursUpdate');
Route::get('/update/promo/{code}','DashboardController@promoUpdate');
Route::get('/promomateriaal/all','MainController@getAllPromoItems');
Route::get('/beursmateriaal/all','MainController@getAllBeursItems');

Route::get('/setlocale/{lang}','DashboardController@setLocale');

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'], function(){

        Route::get('/', 'MainController@index');

        Route::get('/user','MainController@getUserData');
        Route::get('/inventory/get','MainController@getInventoryItems');
        Route::post('/inventory/updateitemamountnegative','MainController@changeItemAmountNegative');
        Route::post('/beurs/request/save','MainController@saveRequest');

        Route::get('/promoinventory/get','MainController@getPromoInventoryItems');
        Route::post('/promoinventory/updateitemamountnegative','MainController@changePromoItemAmountNegative');
        Route::post('/promo/request/save','MainController@savePromoRequest');
        Route::get('/promoinventory/get','MainController@getPromoInventoryItems');
        Route::get('/requests/all','DashboardController@getAllRequests');
        Route::get('/requests/promo/all','DashboardController@getAllPromoRequests');

        Route::post('/user/updatebudget','MainController@updateBudget');

        Route::get('/emailhandtekeningen/get','DashboardController@getEmailSignaturesForOffice');
        Route::post('/emailhandtekeningen/save', 'DashboardController@saveEmailSignatureForOffice');
        Route::get('/emailhandtekeningen/remove/{sign_id}','DashboardController@removeEmailsignatureForOffice');

        Route::post('/emailhandtekeningen/image','DashboardController@saveSignatureImage');
        Route::get('/emailhandtekeningen/download/{image}','DashboardController@downloadSignature');

        Route::get('/logos/all','DashboardController@getLogos');
        Route::get('/logos/download/{image}','DashboardController@downloadLogo');

        Route::get('/promoaanvragen/all','AdminController@allPromoRequests');
        Route::get('/beursaanvragen/all','AdminController@allBeursRequests');

        Route::get('/emailhandtekeningen/all','AdminController@getAllSignatures');
        Route::get('/emailhandtekeningen/approve/{id}','AdminController@approveSignature');
        Route::get('/emailhandtekeningen/decline/{id}','AdminController@declineSignature');

        Route::get('/promo/detail/{id}','DashboardController@getPromoRequestDetail');
        Route::get('/beurs/detail/{id}','DashboardController@getBeursRequestDetail');

        Route::get('/notifications','DashboardController@getNotifications');
        Route::get('/notifications/read/{id}','DashboardController@markNotificationAsRead');
        Route::get('/notifications/clear/{id}','DashboardController@clearNotificationsList');

        Route::post('/drukwerk/save','DrukwerkController@saveRequest');
        Route::get('/drukwerk/get','DrukwerkController@getAllDrukwerkForUser');
        Route::get('/drukwerk/all','AdminController@getAllDrukwerk');
        Route::get('/drukwerk/detail/{id}','DrukwerkController@getDrukwerkDetail');
        Route::get('/drukwerk/finish/{id}','AdminController@drukwerkFinished');
        Route::get('/drukwerk/remove/{id}','AdminController@removeDrukwerk');
        Route::get('/drukwerk/{id}/files','AdminController@getFilesForDrukwerk');
        Route::get('/drukwerk/download/{file}','AdminController@downloadFile');

        Route::get('/orders/list/{section}','AdminController@getAllInfoInList');
        Route::get('/users/all', 'AdminController@getAllUsers');
        Route::post('/user/update','AdminController@updateUser');

        Route::post('/password/manualreset','DashboardController@changePassword');

        Route::get('/promoaanvragen/remove/{id}', 'AdminController@removePromoItem');
        Route::get('/beursaanvragen/remove/{id}', 'AdminController@removeBeursItem');

        Route::get('/order/remove/promo/{order_id}/{item_id}', 'AdminController@removePromoItemFromOrder');
        Route::get('/order/remove/beurs/{order_id}/{item_id}', 'AdminController@removeBeursItemFromOrder');
        
    });




});
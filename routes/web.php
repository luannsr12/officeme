<?php
/**
 * This file contains all the routes for the project
 */

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::csrfVerifier(new \OfficeMe\Middlewares\CsrfVerifier());

SimpleRouter::setDefaultNamespace('OfficeMe\\Controllers');

SimpleRouter::group(['exceptionHandler' => \OfficeMe\Handlers\HandlersMain::class], function () {


    /* Api login not auth */
    SimpleRouter::post('/api/auth', 'Global\AuthController@auth');

    /* Webhook Whatsapp */
    SimpleRouter::match(['get', 'post'], '/webhook/telegram', 'Global\WebhookController@telegram');
    
    // API
    SimpleRouter::group(['prefix' => '/api', 'middleware' => \OfficeMe\Middlewares\ApiVerification::class], function () {

        #=============================================================#
        #========================= ADMIN GROUP =======================#
        #=============================================================#

        /*users*/
        SimpleRouter::get('/customers/list', 'Admin\CustomersController@list');

        /*financial*/
        SimpleRouter::get('/financial/list', 'Admin\FinancialController@list');
        SimpleRouter::get('/financial/get/{id}', 'Admin\FinancialController@get');
        SimpleRouter::post('/financial/edit/{id}', 'Admin\FinancialController@edit');
        SimpleRouter::post('/financial/add', 'Admin\FinancialController@add');
        SimpleRouter::post('/financial/remove/{id}', 'Admin\FinancialController@delete');
        SimpleRouter::post('/financial/multiple/remove', 'Admin\FinancialController@delete_multiple');

        /*Plataforms*/
        SimpleRouter::post('/plataforms/add', 'Admin\PlataformsController@add');
        SimpleRouter::get('/plataforms/list', 'Admin\PlataformsController@list');

        /* Setting payments*/
        SimpleRouter::post('/payment/split/generate/link/{id}', 'Api\PaymentsController@generate_link_split');
        SimpleRouter::post('/payment/setting/edit/{id}', 'Api\PaymentsController@savePaymentSettings');

        /*Statistics*/
        SimpleRouter::get('/statistics/dashboard/one', 'Admin\StatisticsController@dashboard_one');

        /*Settings*/
        SimpleRouter::post('settings/profile/save', 'Admin\SettingsController@saveprofile');

        #=============================================================#
        #=============================================================#
        #=============================================================#


    });


    /* Logout and Login */
    SimpleRouter::get('/logout', 'Pages\Dashboard@logout')->name('logout');
    SimpleRouter::get('/login', 'Pages\Dashboard@index')->name('dashboard');

    /*Pages*/
    SimpleRouter::group(['prefix' => '/p', 'middleware' => \OfficeMe\Middlewares\Logged::class], function () {

        // Page global
        SimpleRouter::get('/dashboard', 'Pages\Dashboard@index')->name('dashboard');


        #========================= ADMIN GROUP =======================#
        if(is_admin()){
            SimpleRouter::get('/plataforms', 'Pages\Admin\Plataforms@index')->name('plataforms');
            SimpleRouter::get('/plataforms/settings/{id}', 'Pages\Admin\Plataforms@setting_bot')->name('setting_bot');
            SimpleRouter::get('/settings/profile', 'Pages\Admin\Settings@profile')->name('settings_profile');
            SimpleRouter::get('/customers', 'Pages\Admin\Customers@index')->name('customers');
            SimpleRouter::get('/financial', 'Pages\Admin\Financial@index')->name('financial');
            SimpleRouter::get('/gateways', 'Pages\Admin\Gateways@index')->name('gateways');
            SimpleRouter::get('/gateways/edit/{gateway}', 'Pages\Admin\Gateways@edit_gateway')->name('edit_gateway');
        }
        #=============================================================#

        
        
        #========================= USER GROUP =======================#
        if(!is_admin()){
            // SimpleRouter::get('/plataforms', 'Pages\Plataforms@index')->name('plataforms');
            // SimpleRouter::get('/plataforms/settings/{id}', 'Pages\Plataforms@setting_bot')->name('setting_bot');
            // SimpleRouter::get('/settings/profile', 'Pages\Settings@profile')->name('settings_profile');
            // SimpleRouter::get('/customers', 'Pages\Customers@index')->name('customers');
            // SimpleRouter::get('/financial', 'Pages\Financial@index')->name('financial');
            // SimpleRouter::get('/gateways', 'Pages\Gateways\Suitpay@index')->name('gateways');
            // SimpleRouter::get('/gateways/edit/{gateway}', 'Pages\Gateways\Suitpay@edit_gateway')->name('edit_gateway');
            // SimpleRouter::get('/export/financial/{ids?}', 'Api\DownloadController@export_financial');
        }
        #=============================================================#


    });
    

});
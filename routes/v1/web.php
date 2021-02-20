<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API v1 Auth
$router->group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () use ($router) {
    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/login', ['uses' => 'AuthController@login', 'as' => 'auth.auth.login']);
        
        $router->group(['middleware' => 'auth:api'], function () use ($router) {
            $router->get('/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.auth.logout']);
            $router->get('/profile', ['uses' => 'AuthController@viewProfile', 'as' => 'auth.auth.viewProfile']);
            $router->get('/refresh-token', ['uses' => 'AuthController@refreshToken', 'as' => 'auth.auth.refreshToken']);
        });
    });
});

// API v1 Security
$router->group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () use ($router) {
    $router->group(['prefix' => 'security', 'namespace' => 'Security', 'middleware' => 'auth:api'], function () use ($router) {
        $router->group(['prefix' => 'report'], function () use ($router) {
            $router->get('/', ['uses' => 'ReportController@index', 'as' => 'security.report.index']);
            $router->post('/store', ['uses' => 'ReportController@storeReport', 'as' => 'security.report.storeReport']);
            $router->post('/store/detail', ['uses' => 'ReportController@storeReportDetail', 'as' => 'security.report.storeReportDetail']);
        });

        $router->group(['prefix' => 'broadcast'], function () use ($router) {
            $router->get('/', ['uses' => 'BroadcastController@index', 'as' => 'security.broadcast.index']);
        });
    });
});

// API v1 Owner
$router->group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () use ($router) {
    $router->group(['prefix' => 'owner', 'namespace' => 'Owner', 'middleware' => 'auth:api'], function () use ($router) {
        $router->group(['prefix' => 'security/schedule'], function () use ($router) {
            $router->get('/', ['uses' => 'SecurityScheduleController@index', 'as' => 'owner.security.schedule.index']);
            $router->get('/{id}', ['uses' => 'SecurityScheduleController@index', 'as' => 'owner.security.schedule.index']);
            $router->post('/store', ['uses' => 'SecurityScheduleController@storeSecuritySchedule', 'as' => 'owner.security.schedule.storeSecuritySchedule']);
            $router->put('/update/{id}', ['uses' => 'SecurityScheduleController@updateSecuritySchedule', 'as' => 'owner.security.schedule.updateSecuritySchedule']);
            $router->delete('/delete/{id}', ['uses' => 'SecurityScheduleController@deleteSecuritySchedule', 'as' => 'owner.security.schedule.deleteSecuritySchedule']);
        });

        $router->group(['prefix' => 'security'], function () use ($router) {
            $router->get('/', ['uses' => 'SecurityController@index', 'as' => 'owner.security.index']);
            $router->get('/{id}', ['uses' => 'SecurityController@index', 'as' => 'owner.security.index']);
            $router->post('/store', ['uses' => 'SecurityController@storeSecurity', 'as' => 'owner.security.storeSecurity']);
            $router->put('/update/{id}', ['uses' => 'SecurityController@updateSecurity', 'as' => 'owner.security.updateSecurity']);
            $router->delete('/delete/{id}', ['uses' => 'SecurityController@deleteSecurity', 'as' => 'owner.security.deleteSecurity']);
        });

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('/', ['uses' => 'UserController@index', 'as' => 'owner.user.index']);
            $router->get('/{id}', ['uses' => 'UserController@index', 'as' => 'owner.user.index']);
            $router->post('/store', ['uses' => 'UserController@storeUser', 'as' => 'owner.user.storeUser']);
            $router->put('/update/{id}', ['uses' => 'UserController@updateUser', 'as' => 'owner.user.updateUser']);
            $router->delete('/delete/{id}', ['uses' => 'UserController@deleteUser', 'as' => 'owner.user.deleteUser']);
        });

        $router->group(['prefix' => 'people'], function () use ($router) {
            $router->get('/', ['uses' => 'PeopleController@index', 'as' => 'owner.people.index']);
            $router->get('/{id}', ['uses' => 'PeopleController@index', 'as' => 'owner.people.index']);
            $router->post('/store', ['uses' => 'PeopleController@storeSecurity', 'as' => 'owner.people.storeSecurity']);
            $router->put('/update/{id}', ['uses' => 'PeopleController@updateSecurity', 'as' => 'owner.people.updateSecurity']);
            $router->delete('/delete/{id}', ['uses' => 'PeopleController@deleteSecurity', 'as' => 'owner.people.deleteSecurity']);
        });

        $router->group(['prefix' => 'customer'], function () use ($router) {
            $router->get('/', ['uses' => 'CustomerController@index', 'as' => 'owner.customer.index']);
            $router->get('/{id}', ['uses' => 'CustomerController@index', 'as' => 'owner.customer.index']);
            $router->post('/store', ['uses' => 'CustomerController@storeCustomer', 'as' => 'owner.customer.storeCustomer']);
            $router->put('/update/{id}', ['uses' => 'CustomerController@updateCustomer', 'as' => 'owner.customer.updateCustomer']);
            $router->delete('/delete/{id}', ['uses' => 'CustomerController@deleteCustomer', 'as' => 'owner.customer.deleteCustomer']);
        });

        $router->group(['prefix' => 'site/schedule'], function () use ($router) {
            $router->get('/', ['uses' => 'SiteScheduleController@index', 'as' => 'owner.site.schedule.index']);
            $router->get('/{id}', ['uses' => 'SiteScheduleController@index', 'as' => 'owner.site.schedule.index']);
            $router->post('/store', ['uses' => 'SiteScheduleController@storeSiteSchedule', 'as' => 'owner.site.schedule.storeSiteSchedule']);
            $router->put('/update/{id}', ['uses' => 'SiteScheduleController@updateSiteSchedule', 'as' => 'owner.site.schedule.updateSiteSchedule']);
            $router->delete('/delete/{id}', ['uses' => 'SiteScheduleController@deleteSiteSchedule', 'as' => 'owner.site.schedule.deleteSiteSchedule']);
        });

        $router->group(['prefix' => 'site'], function () use ($router) {
            $router->get('/', ['uses' => 'SiteController@index', 'as' => 'owner.site.index']);
            $router->get('/{id}', ['uses' => 'SiteController@index', 'as' => 'owner.site.index']);
            $router->post('/store', ['uses' => 'SiteController@storeSite', 'as' => 'owner.site.storeSite']);
            $router->put('/update/{id}', ['uses' => 'SiteController@updateSite', 'as' => 'owner.site.updateSite']);
            $router->delete('/delete/{id}', ['uses' => 'SiteController@deleteSite', 'as' => 'owner.site.deleteSite']);
        });

        $router->group(['prefix' => 'schedule'], function () use ($router) {
            $router->get('/', ['uses' => 'ScheduleController@index', 'as' => 'owner.schedule.index']);
            $router->get('/{id}', ['uses' => 'ScheduleController@index', 'as' => 'owner.schedule.index']);
            $router->post('/store', ['uses' => 'ScheduleController@storeSchedule', 'as' => 'owner.schedule.storeSchedule']);
            $router->put('/update/{id}', ['uses' => 'ScheduleController@updateSchedule', 'as' => 'owner.schedule.updateSchedule']);
            $router->delete('/delete/{id}', ['uses' => 'ScheduleController@deleteSchedule', 'as' => 'owner.schedule.deleteSchedule']);
        });

        $router->group(['prefix' => 'corporate'], function () use ($router) {
            $router->get('/', ['uses' => 'CorporateController@index', 'as' => 'owner.corporate.index']);
            $router->get('/{id}', ['uses' => 'CorporateController@index', 'as' => 'owner.corporate.index']);
            $router->post('/store', ['uses' => 'CorporateController@storeCorporate', 'as' => 'owner.corporate.storeCorporate']);
            $router->put('/update/{id}', ['uses' => 'CorporateController@updateCorporate', 'as' => 'owner.corporate.updateCorporate']);
            $router->delete('/delete/{id}', ['uses' => 'CorporateController@deleteCorporate', 'as' => 'owner.corporate.deleteCorporate']);
        });
    });
});

// API v1 Client
$router->group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () use ($router) {
    $router->group(['prefix' => 'owner', 'namespace' => 'Client', 'middleware' => 'auth:api'], function () use ($router) {
        // Code start from here
    });
});

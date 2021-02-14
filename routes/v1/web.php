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
$router->group(['prefix' => 'api/v1'], function () use ($router) {
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
$router->group(['prefix' => 'api/v1'], function () use ($router) {
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
$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => 'owner', 'namespace' => 'Owner', 'middleware' => 'auth:api'], function () use ($router) {
        // Code start from here
    });
});

// API v1 Client
$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => 'owner', 'namespace' => 'Client', 'middleware' => 'auth:api'], function () use ($router) {
        // Code start from here
    });
});

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

// 第三方平台联合登录
$router->group(['prefix' => 'login'], function () use ($router) {
    $router->post('email', 'LoginController@email');
    $router->post('email_code', 'LoginController@emailCode');

    $router->get('gg', 'LoginController@googleBack');
    $router->get('ff', 'LoginController@facebookBack');
});

// 个人中心
$router->group(['prefix' => 'user'], function() use ($router) {
    $router->post('personal', 'PersonalController@personalInfo');
    $router->post('bill', 'PersonalController@billInfo');
    $router->post('import', 'PersonalController@importData');
    $router->post('pay', 'PersonalController@pay');
    $router->post('pay_return', 'PersonalController@payReturn');

});

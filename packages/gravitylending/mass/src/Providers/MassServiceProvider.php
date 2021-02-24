<?php

declare(strict_types=1);

namespace GravityLending\Mass\Providers;


use GravityLending\Mass\Exceptions\ApiHandler;
use GravityLending\Mass\Http\Controllers\ApiController;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\Router;

class MassServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
//    public $singletons = [
//        ExceptionHandler::class => ApiHandler::class,
//    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([__DIR__ . '/config/mass.php' => $this->app->configPath('mass.php')]);
        $this->app->register(RouteServiceProvider::class);
//        $this->commands('Appzcoder\LumenRoutesList\RoutesCommand');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
//    public function boot(Router $route)
    public function boot()
    {

//        dd(dirname(__FILE__) . './routes.php');

//        $this->loadRoutesFrom(dirname(__DIR__, 1) . '/routes.php');
//        $route->get('rrrr', function(){
//            dd('sdfdsfdsf');
//        });


//        Route::apiResource('types',ApiController::class)
//            ->names('CampaignType')
//            ->parameters(['types' => 'campaign_type:id']);
//
//        Route::apiResource('promos',ApiController::class)
//            ->names('PromoCode')
//            ->parameters(['promos' => 'promo_code:id']);
//
//        Route::apiResource('campaigns',ApiController::class)
//            ->names('Campaign')
//            ->parameters(['campaigns' => 'campaign_id:id']);


//        $router->group([], function () {
//
//        }):

//        $router->group();

//        Route::get('test', function() {
//            return 'test';
//        });
//        $this->app-
//        $this->loadRoutesFrom(__DIR__ . '../routes.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace GravityLending\Mass\Providers;

//use App\Models\Campaign;
//use App\Models\CampaignType;
//use App\Models\PromoCode;

//use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\ServiceProvider;

//use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

use Laravel\Lumen\Routing\Router;
use mmghv\LumenRouteBinding\RouteBindingServiceProvider;

class RouteServiceProvider extends RouteBindingServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param Router $r
     * @return void
     */


    public function makeRoutes(Router $r)
    {
        $r->group([
            'namespace' => 'GravityLending\Mass\Http\Controllers'
        ], function (Router $r) {

//            $r->addRoute(['GET', 'POST'], 'campaigns', 'Mass@index');

            $r->addRoute(['POST'], 'campaigns', 'Mass@store');
            $r->addRoute(['GET'], 'campaigns', 'Mass@index');
            $r->addRoute(['GET'], 'campaigns/{id}', 'Mass@show');
            $r->addRoute(['PUT', 'PATCH'], 'campaigns/{id}', 'Mass@update');
            $r->addRoute(['DELETE'], 'campaigns/{id}', 'Mass@destroy');


//            dd($r->getRoutes());

//            $this->app->get($uri, 'App\Http\Controllers\\' . $controller . '@index');
//            $this->app->post($uri, 'App\Http\Controllers\\' . $controller . '@store');
//            $this->app->get($uri . '/{id}', 'App\Http\Controllers\\' . $controller . '@show');
//            $this->app->put($uri . '/{id}', 'App\Http\Controllers\\' . $controller . '@update');
//            $this->app->patch($uri . '/{id}', 'App\Http\Controllers\\' . $controller . '@update');
//            $this->app->delete($uri . '/{id}', 'App\Http\Controllers\\' . $controller . '@destroy');


        });
    }


    public function boot(Router $r)
    {
        $this->makeRoutes($r);

        // The binder instance
        $binder = $this->binder;


//        $binder->compositeBind();

        // Here we define our bindings
        $binder->bind('campaign', 'App\Campaign');
//        $binder->bind('article', 'App\Article@findForRoute');
//        $binder->bind('article', function($value) {
//            return \App\Article::where('slug', $value)->firstOrFail();
//        });
//
//        $binder->implicitBind('App'); // DO THIS!
    }


    public function bootrrr()
    {
//        try {
//            dd(ClassFinder::getClassesInNamespace('\\App'));
//        } catch(\Exception $e) {
//            dd($e);
//        }

//        $models = $this->getModels();
        // get models from namespace

        // filter models using HasRoutes trait

//        dd($models);

        // include/exclude routes to generate

        $this->model('campaign_type', config('mass.namespace') . 'CampaignType');
        $this->model('campaign_id', config('mass.namespace') . 'Campaign');



//        Route::model('campaign_type', CampaignType::class);
//        Route::model('campaign_id', Campaign::class);




//        Route::bind('promo_code', function ($value) {
//            return PromoCode::search($value);
//        });
    }


    protected function getModels()
    {
        return ClassFinder::getClassesInNamespace(config('mass.namespace'), ClassFinder::RECURSIVE_MODE);
    }


}

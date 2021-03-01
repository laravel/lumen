<?php

declare(strict_types=1);

namespace GravityLending\Mass\Providers;

use GravityLending\Mass\Http\Middleware\RouteMiddleware;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use GravityLending\Mass\Console\MassiveRoutesCommand;
use GravityLending\Mass\Exceptions\ApiHandler;

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
        $this->app->routeMiddleware([
            'massive' => RouteMiddleware::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @param Filesystem $files
     * @return void
     */
    public function boot(Filesystem $files)
    {
        if ($this->app->runningInConsole()) {
            $this->commands(MassiveRoutesCommand::class);
        }
        $routeFile = 'routes/massive.php';
        if($files->exists(base_path($routeFile))){
            $this->loadRoutesFrom(base_path($routeFile));
        };
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return ['mass'];
    }
}

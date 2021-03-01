<?php

declare(strict_types=1);

namespace GravityLending\Mass\Console;

use GravityLending\Mass\Models\Massive;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MassiveRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'massive:routes {model? : Model to create routes for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API Routes for Massive Models';

    /**
     * @var Filesystem
     */
    private $files;

    /**
     * HTTP actions/methods
     * @var array
     */
    protected $methods = [
        'store' => 'POST',
        'index' => 'GET',
        'show' => 'GET',
        'update' => 'PUT',
        'destroy' => 'DELETE',
    ];

    protected $namespace = 'App\Models';

    protected $routes = "\n";

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->files = $filesystem;
    }

    public function handle()
    {
        if($this->argument('model')) {
            $routeModels[] = $this->namespace . '\\' . $this->argument('model');
        } else {
            $routeModels = $this->getModels();
        }
        $bar = $this->output->createProgressBar(count($routeModels));
        foreach ($routeModels as $class) {
            $model = new $class;
            $trait = 'GravityLending\Mass\Http\Traits\HasRoutes';
            if(in_array($trait, class_uses($model))) {
                $this->createRoutes($model);
            }
            $this->newLine();
            $this->info(class_basename($class) . ' routes created.');
            $bar->advance();
        }
        $this->writeRoutes();
        $bar->finish();
        $this->info('Massive Routes Generated!');
        $this->callSilent('cache:clear');
    }

    protected function createRoutes(Massive $model) {
        $conf = property_exists($model, 'routing') ? $model::$routing : null;
        $resource = $model->getResource('plural');
        $bind = 'id'; //$model->getBindKey($model);
        $this->routes .= "\tRoute::group(['middleware' => 'massive:" . class_basename($model) . "'], function(){\n";
        foreach ($conf['methods'] ?? array_keys($this->methods) as $action) {
            $method = Str::lower($this->methods[$action]);
            if (in_array($action, ['store', 'index'])) {
                $this->routes .= "\t\tRoute::" . $method . "('" . $resource . "', ['uses' => 'Mass@" . $action . "']);\n";
            } else {
                $this->routes .= "\t\tRoute::" . $method . "('" . $resource . '/{' . $bind . '}' . "', ['uses' => 'Mass@" . $action . "']);\n";
            }
        }
        $this->routes .= "\t});\n";
    }

    protected function writeRoutes()
    {
        $stub = $this->files->get(__DIR__ . '/../routes.stub');
        $routeFile = str_replace('{{replace}}', $this->routes, $stub);
        $this->files->replace(base_path() . '/routes/massive.php', $routeFile);
    }

    protected function getModels()
    {
        return ClassFinder::getClassesInNamespace($this->namespace, ClassFinder::RECURSIVE_MODE);
    }
}

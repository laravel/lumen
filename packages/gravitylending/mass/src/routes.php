<?php

declare(strict_types=1);

use Laravel\Lumen\Routing\Router;
use GravityLending\Mass\Http\Controllers\ApiController;
//use Illuminate\Support\Facades\Route;
//use FastRoute\Route;


use Illuminate\Support\Facades\Route;


// todo remove duplicate source, load via Model routes generate
//Route::apiResource('types',ApiController::class)
//    ->names('CampaignType')
//    ->parameters(['types' => 'campaign_type:id']);


//$app->get('posts/{postId}/comments/{commentId}', function ($postId, $commentId) {
//    //
//});

//$app->get($uri, $callback);
//$app->post($uri, $callback);
//$app->put($uri, $callback);
//$app->patch($uri, $callback);
//$app->delete($uri, $callback);

$this->app->router->group([
    'namespace' => 'GravityLending\Mass\Http\Controllers'
], function (Router $r) {


//    $r->addRoute(['GET', 'POST'], 'campaigns', 'Mass@index');

//    $r->get('campaigns', 'Mass@index');
//    $r->get('campaigns', ApiController::class);

//    $fileSystemIterator = new FilesystemIterator(app_path() . '/Models'); // todo: use config('mass.namespace')
//    foreach ($fileSystemIterator as $file) {
//        if ($file->getExtension() == 'php') {
//
//            $class = config('mass.namespace') . str_replace('.php', '', $file->getFilename());
//
//            $uses = class_uses($class);
//
//            dd($class, $uses);
//
//
//
//            $test = in_array('HasRoutes', class_uses($class));
//
//
////            $uses = class_uses(config('mass.namespace') . $class, true);
//            dd($uses);
//        }
//    }

//    dd($models);




    // todo remove duplicate source, load via Model routes generate
//    Route::apiResource('types',ApiController::class)
//        ->names('CampaignType')
//        ->parameters(['types' => 'campaign_type:id']);
//
//    Route::apiResource('promos',ApiController::class)
//        ->names('PromoCode')
//        ->parameters(['promos' => 'promo_code:id']);
//
//    Route::apiResource('campaigns',ApiController::class)
//        ->names('Campaign')
//        ->parameters(['campaigns' => 'campaign_id:id']);

//    Route::apiResource('funding', FundingController::class); // todo import route

});

//Route::fallback(function(){});

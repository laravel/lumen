<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

class SomeEvent implements Illuminate\Contracts\Broadcasting\ShouldBroadcast {
	public $something = 'taylor';
	public function broadcastOn()
	{
		return ['test-channel'];
	}
}

$app->get('/', function() use ($app) {
	event(new SomeEvent);
    return $app->welcome();
});

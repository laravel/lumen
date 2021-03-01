<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'GravityLending\Mass\Http\Controllers'], function() {
	Route::group(['middleware' => 'massive:Campaign'], function(){
		Route::get('campaigns', ['uses' => 'Mass@index']);
		Route::get('campaigns/{id}', ['uses' => 'Mass@show']);
	});
	Route::group(['middleware' => 'massive:CampaignType'], function(){
		Route::post('types', ['uses' => 'Mass@store']);
		Route::get('types', ['uses' => 'Mass@index']);
		Route::get('types/{id}', ['uses' => 'Mass@show']);
		Route::put('types/{id}', ['uses' => 'Mass@update']);
		Route::delete('types/{id}', ['uses' => 'Mass@destroy']);
	});
	Route::group(['middleware' => 'massive:PromoCode'], function(){
		Route::post('promos', ['uses' => 'Mass@store']);
		Route::get('promos', ['uses' => 'Mass@index']);
		Route::get('promos/{id}', ['uses' => 'Mass@show']);
		Route::put('promos/{id}', ['uses' => 'Mass@update']);
		Route::delete('promos/{id}', ['uses' => 'Mass@destroy']);
	});
});

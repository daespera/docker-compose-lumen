<?php

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

use Illuminate\Http\Response;

$app->get('/',[ function () use ($app) {
   error_reporting(E_ALL & ~E_NOTICE); 

Cache::store('memcahed')->put('bar', 'baz', 10);

}]);

$app->post('oauth/access_token', function() {
    return response()->json(Authorizer::issueAccessToken());
});

//users
$app->group(['prefix' => 'api/v1'], function () use ($app) {
	
	
	$app->post('User', [
		'middleware' => ['oauth'],
		'uses' => 'App\Http\Controllers\UserController@create'
	]);

	/*$app->get('{module}', [
		'middleware' => ['oauth'],
		'uses' => 'App\Http\Controllers\ModuleController@create'
	]);*/
});

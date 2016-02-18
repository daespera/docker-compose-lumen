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

$memcache = new Memcached;
$memcache->connect('localhost', 11211) or die ("Could not connect");

$version = $memcache->getVersion();
echo "Server's version: ".$version."<br/>\n";

$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;

$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";

$get_result = $memcache->get('key');
echo "Data from the cache:<br/>\n";

var_dump($get_result);
    //return $app->version();
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

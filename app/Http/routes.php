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

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

$app->get('/',[ function () use ($app) {
   error_reporting(E_ALL & ~E_NOTICE); 

	$mc = new Memcached(); 
	$mc->addServer('cache', 11211); 
	$version = $mc->getVersion();
	print_r($version);




$signer = new Sha256();

$token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
                        ->setAudience('http://example.org') // Configures the audience (aud claim)
                        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                        ->set('uid', 1) // Configures a new claim, called "uid"
                        ->sign($signer, 'testing') // creates a signature using "testing" as key
                        ->getToken(); // Retrieves the generated token

print_r($token);





}]);

$app->post('oauth/access_token', function() {
    return response()->json(Authorizer::issueAccessToken());
});

$app->group(['middleware' => 'oauth','prefix' => 'api/v1'], function () use ($app) {
	
    //users	
	$app->post('users', [
		'uses' => 'App\Http\Controllers\UserController@create'
	]);

	$app->get('users[/{id}]', [
		'uses' => 'App\Http\Controllers\UserController@retrieve'
	]);

    $app->put('users/{id}', [
        'uses' => 'App\Http\Controllers\UserController@update'
    ]);

    $app->delete('users/{id}', [
        'uses' => 'App\Http\Controllers\UserController@delete'
    ]);

    //sites 
    $app->post('sites/upload_banner_image', [
        'middleware' => 'oauth-user',
        'uses' => 'App\Http\Controllers\SiteController@uploadBannerImage'
    ]);

    $app->get('sites/serve_banner_image/{id}', [
        'uses' => 'App\Http\Controllers\SiteController@serve_banner_image'
    ]);

    $app->post('sites/{id}/pages', [
        'uses' => 'App\Http\Controllers\SiteController@createPage'
    ]);

	/*$app->get('{module}', [
		'middleware' => ['oauth'],
		'uses' => 'App\Http\Controllers\ModuleController@create'
	]);*/
});

$app->group(['prefix' => 'api/v1'], function () use ($app) {
    $app->get('sites/serve_banner_image/{id}', [
        'uses' => 'App\Http\Controllers\SiteController@serveBannerImage'
    ]);
    $app->get('sites/render/{id}[/{slug}]', [
        'uses' => 'App\Http\Controllers\SiteController@render'
    ]);
});

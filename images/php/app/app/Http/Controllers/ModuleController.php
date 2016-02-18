<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ModuleController extends BaseController
{
    public function create(Request $request,$module)
    {
		$class = 'App\\Http\\Models\\' . $module;
		$user = new $class();
		$user->'username'= 1;
		print_r($user);

    	print_r($request->except(['access_token']));
    }
}

<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Traits\Controller\CrudTrait;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    
    private $model;

    const MODEL = 'App\Http\Models\User';

    protected $validationRules = [
                'name' => 'required', 
                'email' => 'required|email|unique:users', 
                'password' => 'required'
                ];

    use CrudTrait {
        retrieve as retrieve_db;
    }

    public function __construct(Request $request)
    {
        $this->model = new User;
    }

    public function retrieve(Request $request,$id = null)
    {     
        if(empty($id))
            return $this->retrieve_db($request,$id);
        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => (new User)->retrieve($id)
            ];
        return response()->json($response, $response['code']);
    }

    public function verify($username, $password)
    {
        $user = User::where('email', $username)->first();

        if($user && Hash::check($password, $user->password)){
            return $user->id;
        }

        return false;
    }
    
}

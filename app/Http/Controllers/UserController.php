<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Models\Users;
use App\Http\Traits\Controller\CrudTrait;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    const MODEL = 'App\Http\Models\Users';

    protected $validationRules = array(
        'create' => [
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required'
        ],
        'update' => [
            'email' => 'email|unique:users'
        ]
    );

    use CrudTrait {
        retrieve as retrieve_db;
    }

    public function retrieve(Request $request,$id = null)
    {     
        if (empty($id)) {
            return $this->retrieve_db($request,$id);
        }
        $data['Users'] = array((new Users)->retrieve($id));
        return  $this->succcess($data, 200);
    }

    public function verify($username, $password)
    {
        $user = Users::where('email', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user->id;
        }
        return false;
    }
    
}

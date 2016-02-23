<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Traits\Controller\CrudTrait;

class UserController extends BaseController
{
    
    private $model;

    use CrudTrait {
        retrieve as retrieve2;
    }

    public function __construct(Request $request)
    {
        $this->model = new User;
    }

    public function retrieve($id)
    {     
        return $this->model->retrieve($id);
    }

    public function verify($username, $password)
    {
        return User::where('email', $username)->firstOrFail()->id;
    }
    
}

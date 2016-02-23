<?php
namespace App\Http\Models\Events;

use App\Http\Models\User;
use Cache;

class UserEvent
{
    public function created(User $user){
       //sync to somewhere
        //$value = Cache::get('key');
        //print_r($value);
        Cache::store('memcached')->forever('user-'.$user->id, $user->toArray());
        /*$value = Cache::store('memcached')->pull('user-'.$user->id);
        print_r($value);
        exit();*/
    }
}

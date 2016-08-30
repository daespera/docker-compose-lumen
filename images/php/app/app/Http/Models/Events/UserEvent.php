<?php
namespace App\Http\Models\Events;

use App\Http\Models\User;
use Cache;
use Illuminate\Support\Facades\Hash;

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

    public function saving(User $user){
        $user->password = Hash::make($user->password);
    }

    public function updated(User $user){
       Cache::store('memcached')->pull('user-'.$user->id);
       Cache::store('memcached')->forever('user-'.$user->id, $user->toArray());
    }
}

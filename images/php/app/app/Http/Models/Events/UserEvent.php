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
        $value = Cache::store('memcached')->put('key', 'value', 10);
        print_r($value);
    }
}

<?php
namespace App\Http\Models\Events;

use App\Http\Models\Users;
use App\Http\Models\Sites;
use App\Http\Models\Pages;
use Cache;
use Illuminate\Support\Facades\Hash;

class UsersEvent
{
    public function created(Users $user)
    {
        Cache::store('memcached')->forever('user-'.$user->id, $user->toArray());
        $site = new Sites();
        $site->name = $user->name.' Site';
        $site->css = 'default';
        $site->user()->associate($user);
        $site->save();

        $homePage = new Pages();
        $homePage->title = "Home";
        $homePage->content = "Welcome";
        $homePage->site()->associate($site);
        $homePage->save();
    }

    public function saving(Users $user)
    {
        $user->password = Hash::make($user->password);
    }

    public function updated(Users $user)
    {
       Cache::store('memcached')->pull('user-'.$user->id);
       Cache::store('memcached')->forever('user-'.$user->id, $user->toArray());
    }
}

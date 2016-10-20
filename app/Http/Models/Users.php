<?php
namespace App\Http\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Http\Traits\Model\ModelEventThrower;
use App\Http\Traits\Model\UuidForId;
use Cache;

class Users extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use ModelEventThrower;
    use SoftDeletes;
    use UuidForId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function retrieve ($id)
    {
        return Cache::store('memcached')->get('user-'.$id);
    }

    public function site()
    {
        return $this->hasOne('App\Http\Models\Sites','user_id');
    }

    public function pages()
    {
        return $this->hasManyThrough(
            'App\Http\Models\Pages',
            'App\Http\Models\Sites',
            'user_id',
            'site_id',
            'id'
        );
    }

}

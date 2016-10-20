<?php 
namespace App\Http\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Sites extends Model
{
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo('App\Http\Models\Users', 'user_id');
    }

    public function pages()
    {
        return $this->hasMany('App\Http\Models\Pages');
    }
}
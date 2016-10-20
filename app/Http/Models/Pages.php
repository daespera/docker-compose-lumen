<?php 
namespace App\Http\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Pages extends Model
{
    protected $fillable = ['title','content','slug'];

    public function setSlugAttribute($value) 
    {
        $this->attributes['slug'] = str_slug($value, '-');
    }    

    public function setTitleAttribute($value) 
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value, '-');
    }

    public function site()
    {
        return $this->belongsTo('App\Http\Models\Sites', 'site_id');
    }
}
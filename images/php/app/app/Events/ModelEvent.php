<?php
namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class ModelEvent extends Event
{
    public function __construct()
    {
    
    }

    function ModelEvent($param) {
        return new ModelEvent($param);
    }

    public function created(Model $model)
    {
   	    $array = explode('\\',get_class($model));
   	    $class = 'App\\Http\\Models\\Events\\' . end($array). 'Event';
	      $classInstance = new $class();   	
	      $classInstance->created($model);
    }
  
    public function updated(Model $model)
    {
        $array = explode('\\',get_class($model));
        $class = 'App\\Http\\Models\\Events\\' . end($array). 'Event';
          $classInstance = new $class();    
          $classInstance->updated($model);
    }

    public function saving(Model $model)
    {
        $array = explode('\\',get_class($model));
        $class = 'App\\Http\\Models\\Events\\' . end($array). 'Event';
          $classInstance = new $class();    
          $classInstance->saving($model);
    }

    public function deleted(Model $model)
    {
        //Implement logic
    }
}

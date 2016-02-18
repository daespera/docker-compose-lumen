<?php 
namespace App\Http\Traits\Controller;

use Illuminate\Http\Request;

trait CrudTrait {
    
    public function create(Request $request)
    {       

        foreach ($request->except(['access_token']) as $key => $value)
        {
            $this->model->$key = $value;
        }
        $this->model->save();

        return $this->model->toarray();
    }

    public function update(Request $request)
    {       

        foreach ($request->except(['access_token']) as $key => $value)
        {
            $this->model->$key = $value;
        }
        $this->model->save();

        return $this->model->toarray();
    }
}
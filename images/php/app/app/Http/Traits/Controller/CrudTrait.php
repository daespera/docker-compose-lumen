<?php 
namespace App\Http\Traits\Controller;

use Illuminate\Http\Request;

trait CrudTrait {

    private $m = self::MODEL;

    public function create(Request $request)
    {       
        try
        {
            if(!empty($this->validationRules)){
                $v = \Validator::make($request->all(), $this->validationRules);
                if($v->fails())
                {
                    throw new \Exception("ValidationException");
                }
            }
            $data = $this->m::create($request->all());
            $response = [
                'code' => 201,
                'status' => 'succcess',
                'data' => $data
                ];
            return response()->json($response, $response['code']);
        }catch(\Exception $ex)
        {
           //$data = ['errors' => $v->errors(), 'exception' => $ex->getMessage()];
           $response = [
                'code' => 422,
                'status' => 'error',
                'errors' => $v->errors(), 'exception' => $ex->getMessage(),
                'description' => 'Unprocessable entity'
                ];
            return response()->json($response, $response['code']);
        }
    }

    public function retrieve(Request $request,$id = null)
    {     
        $data = (empty($id)) ? $this->m::all() : $this->m::find($id);

        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => $data
            ];
        return response()->json($response, $response['code']);
    }

    public function update(Request $request,$id)
    {       
        if(!$data = $this->m::find($id))
        {
            $response = [
                'code' => 404,
                'status' => 'error',
                'errors' => 'Resource Not Found', 'exception' => 'Resource Not Found',
                'description' => 'Unprocessable entity'
                ];
            return response()->json($response, $response['code']);
        }
        try
        {
            /*$v = \Validator::make($request->all(), $this->validationRules);
            if($v->fails())
            {
                throw new \Exception("ValidationException");
            }*/
            $data->fill($request->all());
            $data->save();
            $response = [
                'code' => 200,
                'status' => 'succcess',
                'data' => $data
                ];
            return response()->json($response, $response['code']);
        }catch(\Exception $ex)
        {
            $response = [
                'code' => 422,
                'status' => 'error',
                'errors' => $v->errors(), 'exception' => $ex->getMessage(),
                'description' => 'Unprocessable entity'
                ];
            return response()->json($response, $response['code']);
        }
    }
}
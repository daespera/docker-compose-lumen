<?php 
namespace App\Http\Traits\Controller;

use Illuminate\Http\Request;

trait CrudTrait {

    private $entity = self::MODEL;

    public function create(Request $request)
    {       
        try {
            if (!empty($this->validationRules['create'])) {
                $v = \Validator::make($request->all(), $this->validationRules['create']);
                if ($v->fails()) {
                    throw new \Exception("ValidationException");
                }
            }
            $data[substr($this->entity, strrpos($this->entity, '\\') + 1)] = $this->entity::create($request->all());
            return  $this->succcess($data, 201);
        } catch (\Exception $ex) {
            return $this->error($v->errors(), 422, 'Unprocessable entity',  $ex->getMessage());
        }
    }

    public function retrieve(Request $request,$id = null)
    {     
        $fields = $request->input('fields', '*');
        $size = $request->input('size',5);
        $page = $request->input('page',1);
        $offset = ($page - 1) * $size;
        $query = $this->entity::select(explode(',', $fields));
        if ($request->has('search')) {
            $search = $request->input('search','');
            $query->where(
                function ($_query) use ($search) {
                    $criterias = explode(',', $search);
                    foreach ($criterias as $value) {
                        $criteria = explode(':', $value);
                        $_query->where($criteria[0], $criteria[1]);
                    }
                }
            );
        }
        $query->take($size)->skip($offset);
        $data[substr($this->entity, strrpos($this->entity, '\\') + 1)] = (empty($id)) ? $query->get(): array($query->find($id));
        return  $this->succcess($data);
    }

    public function update(Request $request,$id)
    {       
        if (!$data = $this->entity::find($id)) {
            return $this->error(
                array("id" => 'Resource Not Found'),
                404,
                'Entity not found',
                'NotFoundException'
            );
        }
        try {
            if (!empty($this->validationRules['update'])) {
                $v = \Validator::make($request->all(), $this->validationRules['update']);
                if ($v->fails()) {
                    throw new \Exception("ValidationException");
                }
            }
            $data->fill($request->all());
            $data->save();
            $model[substr($this->entity, strrpos($this->entity, '\\') + 1)] = $data;
            return $this->succcess($model);
        } catch(\Exception $ex) {
            return $this->error(
                $v->errors(),
                422,
                'Unprocessable entity',
                $ex->getMessage()
            );
        }
    }

    public function delete($id)
    {       
        $v = array();
        if (!$data = $this->entity::find($id)) {
             return $this->error(
                array("id" => 'Resource Not Found'),
                404,
                'Entity not found',
                'NotFoundException'
            );
        }
        try {
            $data->delete();
            return $this->succcess(
                array('id' => $id),
                200,
                'deleted'
            );
        } catch(\Exception $ex) {
            return $this->error(
                $v->errors(),
                422,
                'Unprocessable entity',
                $ex->getMessage()
            );
        }
    }

    private function succcess(
        $data,
        $code = 200,
        $status = 'succcess'
    ) {
        $response = [
            'code' => $code,
            'status' => $status ,
            'data' => $data
            ];
        return response()->json($response, $code);
    }

    private function error(
        $errors = array('error' => 'Invalid request'),
        $code = 400,
        $description = 'Bad Request',
        $exception = 'Exception'
    ) {
        $response = [
            'code' => $code,
            'status' => 'error',
            'errors' => $errors,
            'description' => $description, 
            'exception' => $exception
        ];
        return response()->json($response, $code);
    }
}
<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;

class BasicController extends Controller {

    public $model;

    public function __construct(Model $model) {

        $this->model = $model;
    }

    public function all() {

        $data = $this->model::all();

        return response()->json(['data' => $data]);
    }
    

    public function find($id) {

        if (!$data = $this->model::find($id)) {

            return response()->json(['message' => "Can't find!"]);
        }

        return response()->json(['data' => $data]);
    }
    

    public function delete($id) {

        if (!$this->model::find($id)) {

            return response()->json(['message' => "Can't find!"]);
        }

        try {
            $this->model::destroy($id);

            return response()->json(['message' => "Deleted!"]);
        } catch (\Exception $e) {

            return response()->json(['message' => "Can't delete!"]);
        }
    }

}

<?php

namespace App\Http\Controllers\Roles;

use App\Role;
use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RolesController extends BasicController {

    public function __construct(Role $role) {

        $this->model = $role;
    }

    public function get_users($id) {

        if (!$role = $this->model->with('users')->where('id', $id)->first()) {

            return response()->json(['message' => "Can't find role!"], 404);
        }

        return response()->json([$role]);
    }

    public function create(Request $request) {

        $this->validate($request, [
            'role_name' => 'required|max:20',
            'role_key' => 'required|max:20'
        ]);

        try {
            $this->model->create($request->all());
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json(['message' => 'Role added successfully!']);
    }

    public function update($id, Request $request) {

        $this->validate($request, [
            'role_name' => 'required|max:20',
        ]);

        try {
            $role = $this->model->find($id);
            $role->update($request->all());
            
        } catch (\Exception $e) {

            return respnonse()->json(['message' => $e->getMessage()], 400);
        }
        
        return response()->json(['message'=>'Updated successfully!']);
    }

}

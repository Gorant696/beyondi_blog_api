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

        if (!$role = Role::with('users')->where('id', $id)->first()) {

            return response()->json(['message' => "Can't find role!"]);
        }

        return response()->json(['data' => $role]);
    }

    public function create(Request $request, Role $role) {

        $this->validate($request, [
            'role_name' => 'required|max:20',
            'role_key' => 'required|max:20'
        ]);

        try {
            $role->name = $request->input('role_name');
            $role->role_key = $request->input('role_key');
            $role->save();
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Role added successfully!']);
    }

    public function update($id, Request $request) {

        $this->validate($request, [
            'role_name' => 'required|max:20',
        ]);

        try {
            $role = Role::find($id);
            $role->name = $request->input('role_name');
            $role->save();
            
        } catch (\Exception $e) {

            return respnonse()->json(['message' => $e->getMessage()]);
        }
        
        return response()->json(['message'=>'Updated successfully!']);
    }

}

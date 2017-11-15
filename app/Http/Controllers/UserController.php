<?php

namespace App\Http\Controllers;

use \App\User;
use \App\Role;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class UserController extends Controller {

    
    
        public function logoutuser() {

        if ($token = JWTAuth::gettoken()) {
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'You have successfully signed out!']);
        }
    }


    public function create(Request $request, User $user) {


        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|max:20',
                //u input treba staviti "password_confirmation" inputi u njemu ponoviti lozinku
        ]);

        $pass = $request->input('password');

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = app('hash')->make($pass);
        $user->save();


        $roles = Role::where('role_key', env('DEFAULT_USER_ROLE'))->first();


        $user->roles()->attach($roles->id);

        return response()->json(['message' => "Wellcome $user->name!"]);
    }

    public function all() {

        $users = User::all();

        return response()->json(['Users' => $users]);
    }

    public function finduser($id) {

        $users = User::find($id);

        return response()->json(['User' => $users]);
    }
    
     public function update($id, Request $request) {

        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:20'
        ]);
        
            
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!']);
            }

            $pass = $request->input('password');

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($pass);
            $user->save();


            return response()->json(['message' => 'Updated successfully!']);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }
    
     public function delete($id) {

        try {
            $user = User::find($id);

            User::destroy($id);

            return response()->json(['message' => "$user->name is deleted"]);
        } catch (\Exception $e) {

            return response()->json(['message' => "Can't delete user!"]);
        }
    }

}

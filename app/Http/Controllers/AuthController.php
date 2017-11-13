<?php

namespace App\Http\Controllers;

use \App\User;
use \App\Roles;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class AuthController extends Controller {

    public function __construct() {
        
    }

    public function login(Request $request) {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'Wrong email or password!'], 401);
        }

        if (Hash::check($request->password, $user->password)) {
            $roles = $user->roles()->get();

            $customclaimsarray = [];

            foreach ($roles as $role) {

                array_push($customclaimsarray, $role->role_key);
            }

            $token = JWTAuth::fromUser($user, ['roles' => $customclaimsarray]);
        } else {
            return response()->json(['error' => 'Wrong email or password!'], 401);
        }

        return response()->json(['token' => $token, 'id' => $user->id]);
    }
    
   

}

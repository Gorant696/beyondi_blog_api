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

class MyController extends Controller {
    

    public function __construct() {

     
    }
    
    public function logoutuser() {

        if ($token = JWTAuth::gettoken()) {
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'You have successfully signed out!']);
        }
    }
    


}
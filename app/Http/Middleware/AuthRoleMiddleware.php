<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class AuthRoleMiddleware {

    public function handle($request, Closure $next) {


        $route = $request->route();
        $actions = $route[1];

        $token = JWTAuth::gettoken();
        $payload = JWTAuth::decode($token);
        $roles = json_decode($payload);

        foreach ($roles->roles as $userRole) {

            if (in_array($userRole, $actions['roles'])) {

                return $next($request);
            } 

        } 
        
        return response()->json(['message' => 'You are not allowed to access this method!']);
    }

}



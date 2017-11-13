<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;
use App\Roles;
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
            $role_permissions = json_decode($payload);
            $nextRoute = false;
       
        foreach ($role_permissions->roles as $userRole => $userPermissions) {
            
        
             
         // $actions['roles'] = ['admin', 'employee', 'editor'],
            if (in_array($userRole, $actions['roles']) || array_key_exists($userRole, $actions['roles'])) { 
                 
                if(isset($actions['roles'][$userRole])) { //$actions['roles']['admin']
                    foreach($actions['roles'][$userRole] as $permission) {
                        if(in_array($permission, $userPermissions)) {
                            $nextRoute = true;
                        }
                    }
                } else {
                    $nextRoute = true;
                }
            }
        }
        
        if($nextRoute) {
            return $next($request);
        }

        return response()->json(['message' => 'You are not allowed to access this method!']);
    
    }

}

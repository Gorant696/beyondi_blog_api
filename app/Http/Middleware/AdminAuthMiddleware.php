<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Post;
use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class AdminAuthMiddleware {
    
    public $model_name;
    
  
    
    public function handle($request, Closure $next) {

        
        $route = $request->route();
        $actions = $route[1];
        $parameters_id = $route[2];
        $token = JWTAuth::gettoken();
        $payload = JWTAuth::decode($token);
        $roles = json_decode($payload);
        
        foreach ($parameters_id as $key=>$value){
            
            if ($key !== 'id'){
                
                $this->model_name = str_replace('_id',"", $key);
                $resource_id=$value;
            } 
        }
        
        foreach ($roles->roles as $userRole) {

            if (in_array($userRole, $actions['roles'])) {

                if ($userRole==User::ROLE_ADMIN){
                    
                 return $next($request);   
                }
                
                if($userRole !==User::ROLE_ADMIN){

                    $auth_user = JWTAuth::parseToken()->toUser();

                    switch ($this->model_name){
                        
                        case 'post':
                            
                            if (!$model = Post::find($resource_id)){
                        
                                return response()->json(['message' => 'Something went wrong. Please try again!']);
                             }
                    
                            if($model->user_id == $auth_user->id){
                        
                                return $next($request);   
                            }
                            
                            break;
                            
                        case 'user':
                            
                            if (!$model = User::find($resource_id)){
                        
                                return response()->json(['message' => 'Something went wrong. Please try again!']);
                             }
                    
                            if($model->user_id == $auth_user->id){
                        
                                return $next($request);   
                            }
                            
                            break;
                            
                        case 'comment':
                            
                            if (!$model = Comment::find($resource_id)){
                        
                                return response()->json(['message' => 'Something went wrong. Please try again!']);
                             }
                    
                            if($model->user_id == $auth_user->id){
                        
                                return $next($request);   
                            }
                            
                            break;
                            
                        case 'like':
                            
                            if (!$model = Like::find($resource_id)){
                        
                                return response()->json(['message' => 'Something went wrong. Please try again!']);
                             }
                    
                            if($model->user_id == $auth_user->id){
                        
                                return $next($request);   
                            }
                            
                            break;    
                    }
                }
            } 
        } 
        return response()->json(['message' => 'You are not allowed to access this method!']);
    }
}




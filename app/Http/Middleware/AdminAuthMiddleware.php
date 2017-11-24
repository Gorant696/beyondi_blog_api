<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Post;
use App\Comment;
use App\Like;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class AdminAuthMiddleware {

    public $model_name;

    public function __construct(Post $post, User $user, Comment $comment, Like $like, Visitor $visitor) {

        $this->post = $post;
        $this->user = $user;
        $this->comment = $comment;
        $this->like = $like;
        $this->visitor = $visitor;
    }

    public function handle($request, Closure $next) {

        
        $route = $request->route();
     
        $actions = $route[1];
        $parameters_id = $route[2];
        $token = JWTAuth::gettoken();
        $payload = JWTAuth::decode($token);
        $roles = json_decode($payload);

        foreach ($parameters_id as $key => $value) {

            if ($key !== 'id') {

                $this->model_name = str_replace('_id', "", $key);
                $resource_id = $value;
            }
        }

        foreach ($roles->roles as $userRole) {

            if (in_array($userRole, $actions['roles'])) {

                if ($userRole == User::ROLE_ADMIN) {

                    return $next($request);
                }

                if ($userRole !== User::ROLE_ADMIN) {

                    switch ($this->model_name) {

                        case 'post':

                            $post= $this->check($this->post, $resource_id, $request, $next);
                            return $post; break;
                        
                        case 'comment':

                            $comment = $this->check($this->comment, $resource_id, $request, $next);
                            return $comment; break;

                        case 'like':

                            $like= $this->check($this->like, $resource_id, $request, $next);
                            return $like; break;
                        
                        case 'visitor':

                            $like= $this->check($this->visitor, $resource_id, $request, $next);
                            return $like; break;
                            
                            
                         case 'user':
                             
                            $auth_user = JWTAuth::parseToken()->toUser();
                             
                            if (!$model = User::find($resource_id)) {

                                return response()->json(['message' => 'Something went wrong. Please try again!']);
                            }

                            if ($model->id == $auth_user->id) {

                                return $next($request);
                            }

                            break;    
                    }
                }
            }
        }
        return response()->json(['message' => 'You are not allowed to access this method!']);
    }

    
    protected function check($model, $resource_id, $request, $next) {

        $auth_user = JWTAuth::parseToken()->toUser();

        if (!$model = Post::find($resource_id)) {

            return response()->json(['message' => 'Something went wrong. Please try again!']);
        }

        if ($model->user_id == $auth_user->id) {

            return $next($request);
        }
        
        return response()->json(['message' => 'You are not allowed to access this method!']);
    }

}

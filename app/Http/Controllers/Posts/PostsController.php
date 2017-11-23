<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\BasicController;
use App\Post;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class PostsController extends BasicController {

  
     public function __construct(Post $post) {
        
        $this->model = $post;
     
    }
    
   


}
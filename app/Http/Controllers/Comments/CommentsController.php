<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\BasicController;
use App\Comment;
use App\Likes;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class CommentsController extends BasicController {

  
    public function __construct(Comment $comment) {
        
        $this->model = $comment;
     
    }
    
  
    

}
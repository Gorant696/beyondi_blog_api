<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Post;
use App\Relatedpost;
use App\Similarpost;
use App\Visitor;
use App\Comment;
use App\Subtopic;
use App\Topic;
use App\Like;
use App\Tag;
use App\Status;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class PostsController extends Controller {

  
    public function __construct() {

     
    }
    
    public function all(){
        
        $posts=Post::all();
        
        return response()->json(['Posts'=>$posts]);
        
        
    }
    
    public function similar(){
        
   $data= User::all();
   
   return response()->json(['Posts'=>$data]);
        
    }
    

}
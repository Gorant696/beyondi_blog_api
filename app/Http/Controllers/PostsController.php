<?php

namespace App\Http\Controllers;

use \App\User;
use \App\Roles;
use \App\Posts;
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
        
        $posts=Posts::all();
        
        return response()->json(['Posts'=>$posts]);
        
        
    }



}

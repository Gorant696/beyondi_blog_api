<?php

namespace App\Http\Controllers;

use App\Like;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class LikesController extends Controller {

  
    public function __construct() {

     
    }
    
    public function all(){
        
        return response()->json([]);
        
    }
    
    public function findlike($id){
        
        return response()->json([]);
        
    }
    
    public function create(){
        
        return response()->json([]);
        
    }
    
     public function update($id){
        
        return response()->json([]);
        
    }
    
    public function delete($id){
        
        return response()->json([]);
        
    }
    

}
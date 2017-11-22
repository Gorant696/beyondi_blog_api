<?php

namespace App\Http\Controllers\Topics;

use App\Http\Controllers\BasicController;
use App\Topic;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class TopicsController extends BasicController {

  
   public function __construct(Topic $topic) {
        
        $this->model = $topic;
     
    }
    
    public function create(){
        
        
        
    }
    
 
    

}
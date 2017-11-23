<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\BasicController;
use App\Post;
use App\Comment;
use App\Relatedpost;

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
    
    public function get_visitors($id){
        
        
        if(!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Can't find!"]);
            
        }
        
        $data= $model->visitors()->get();
        
        return response()->json(['message' => $data]);
        
    }
    
    public function get_comments($id){
        
        if (!$model=$this->model->find($id)){
            
            return response()->json(['message' => "Can't find!"]);
        }
        
        $data= $model->comments()->get();
        
        return response()->json(['message' => $data]);
        
    }
    
    public function get_comment($id, $comment_id){
        
        if (!$data=Comment::where('id', $comment_id)->where('post_id', $id)->first()){
            
            return response()->json(['message' => "Can't find!"]);
        }
        
         return response()->json(['message' => $data]);
        
    }
    
    public function get_relatedposts($id){
        
        if (!$model = $this->model->find($id)){
            
           return response()->json(['message' => "Can't find!"]); 
        }
        
        $data = $model->relatedposts()->get();
        
        return response()->json(['message' => $data]);
    }
    
   


}
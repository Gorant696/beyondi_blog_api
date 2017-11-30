<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\BasicController;
use App\Comment;
use App\Like;

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
    
    public function get_likes($id){
        
       if (!$model = $this->model->find($id)){
           
           return response()->json(['message' => "Something went wrong. Please try again!"], 404);
       }
       
       $likes = $model->likes()->with('users')->get();
       
       return response()->json([$likes]);
        
    }
    
    public function create_like($id){
        
        if (!$comment = $this->model->find($id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        $auth_user = JWTAuth::parseToken()->toUser();
        
        try {
        $comment->likes()->create([
            'comment_id'=> $id,
            'user_id'=> $auth_user->id,
            'like'=> '1'
        ]);
        } catch (\Exception $e){
            
            return response()->json(['data' => 'You already liked this comment!'], 400);
        }
        
        return response()->json(['data' => 'You like this comment!']);
        
    }
    
    public function delete_like($id, $like_id, Like $like){
        
        $this->model = $like;
        
        if (!$like_find = $like->where('comment_id', $id)->where('id', $like_id)->first()){
            
            return response()->json(['message' => "Can't find!"], 404);
        }
        
         return $this->delete($like_find->id);
    }
    
  
    

}
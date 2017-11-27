<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\BasicController;
use App\Post;
use App\Comment;
use App\Relatedpost;
use App\Similarpost;
use App\Visitor;
use App\Status;
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
    
     public function get_relatedpost($id, $relatedpost_id){
        

        if (!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Can't find!"]); 
        }
        
        
        if (!$data= $model->relatedposts()->where('relatedpost_id', $relatedpost_id)->first()){
            
            return response()->json(['message' => "Can't find!"]); 
        }
 
        
        return response()->json(['message' => $data]);
    }
    
    
    public function get_similarposts($id){
        
        if (!$model = $this->model->find($id)){
            
           return response()->json(['message' => "Can't find!"]); 
        }
        
        $data = $model->similarposts()->get();
        
        return response()->json(['message' => $data]);
    }
    
    
    public function get_similarpost($id, $similarpost_id){
        
        if (!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Can't find!"]); 
        }
        
        if (!$data= $model->similarposts()->where('similarpost_id', $similarpost_id)->first()){
            
            return response()->json(['message' => "Can't find!"]); 
        }
 
        return response()->json(['message' => $data]);
    }
    
    
    public function delete_visitors($post_id, Visitor $visitor){
        
        $find = $visitor->where('post_id', $post_id)->get();
        $data = $find->pluck('id');

            foreach ($data as $delete_id){

                $visitor->destroy($delete_id);
            }

        return response()->json(['message' => 'Deleted!']);
    }
    
    public function delete_comment($id, $comment_id, Comment $comment){
        
        
         $this->model = $comment;
        
        if (!$comment_find = $this->model->where('post_id', $id)->where('id', $comment_id)->first()){
            
            return response()->json(['message' => "Can't find!"]);
            
        }
        
        return $this->delete($comment_find->id);
        
    }
    
    
     public function delete_relatedpost($id, $post_id, Relatedpost $relatedpost){
        
         $this->model = $relatedpost;
        
        if (!$relatedpost_find = $this->model->where('post_id', $post_id)->where('id', $id)->first()){
            
            return response()->json(['message' => "Can't find!"]);
        }
        
        return $this->delete($relatedpost_find->id);
    }
    
    
      public function delete_similarpost($id, $post_id, Similarpost $similarpost){
        
         $this->model = $similarpost;
        
        if (!$similarpost_find = $this->model->where('post_id', $post_id)->where('id', $id)->first()){
            
            return response()->json(['message' => "Can't find!"]);
        }
        
        return $this->delete($similarpost_find->id);
    }
    
    
    public function create_comment($id, Request $request){
        
        $this->validate($request, [
            'content' => 'required',
        ]);
        
        if (!$post = $this->model->find($id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        
        $auth_user = JWTAuth::parseToken()->toUser();
        
        try {
        $post->comments()->create([
            'content'=> $request->input('content'),
            'user_id' => $auth_user->id,
            'post_id' => $id
        ]);
        } catch (\Exception $e){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        
        return response()->json(['message' => "Comment created successfully!"]);
        
    }
    
    public function create_relatedpost($post_id, Request $request){
        
        $this->validate($request, [
            'relatedpost_id'=> 'required'
        ]);
        
         if (!$post = $this->model->find($post_id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        
        try {
        $post->relatedposts()->create([
            'post_id'=>$post_id,
            'relatedpost_id'=>$request->input('relatedpost_id')
        ]);
        } catch (\Exception $e){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        return response()->json(['message' => "You successfully added related post!"]);
    }
    
    
    public function create_similarpost($post_id, Request $request){
        
        $this->validate($request, [
            'similarpost_id'=> 'required'
        ]);
        
         if (!$post = $this->model->find($post_id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        
        try {
        $post->similarposts()->create([
            'post_id'=>$post_id,
            'similarpost_id'=>$request->input('similarpost_id')
        ]);
        } catch (\Exception $e){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        return response()->json(['message' => "You successfully added related post!"]);
    }
    
    
    public function update_comment($id, $comment_id, Request $request, Comment $comment){
        
        $this->validate($request, [
            'content' => 'required',
        ]);
        
        if (!$model = $comment->where('id', $comment_id)->where('post_id', $id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        
        try {
            $model->update($request->all());
        } catch (\Exception $e){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]);
        }
        return response()->json(['message' => "Comment updated successfully!"]);
    }
    
    
    public function attach_tag($id, $post_id){
        
        if (!$model =$this->model->find($post_id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"]); 
        }
        
        try{
            
            $model->tags()->attach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"]); 
        }
        
         return response()->json(['message' => "Tag added successfully!"]); 
    }
    
    public function detach_tag($id, $post_id){
        
        if (!$model =$this->model->find($post_id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"]); 
        }
        
        try{
            
            $model->tags()->detach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"]); 
        }
        
         return response()->json(['message' => "Tag removed successfully!"]); 
    }
    
    
    public function get_tags($id){
        
        if (!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"]); 
        }
        $data = $model->tags()->get();

        return response()->json(['message' => $data]); 
       
    }
    
    
    public function get_subscribes($id){
        
        $status = Status::where('status_key', 'published')->first();
        
        if (!$model = $this->model->where('id', $id)->where('status_id', $status->id)->first()){
            
             return response()->json(['message' => "Something went wrong. Please try again!"]);  
        }
        
       $subscribes = $model->subscribes()->with('users')->get()->pluck('users');

        return response()->json(['data' => $subscribes]); 
    }
}
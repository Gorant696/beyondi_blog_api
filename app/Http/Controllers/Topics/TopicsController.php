<?php

namespace App\Http\Controllers\Topics;

use App\Http\Controllers\BasicController;
use App\Topic;
use App\Subtopic;
use App\Post;
use App\Status;

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
    
    public function create(Request $request){
        
         $this->validate($request, [
            'name' => 'required|max:50',
            'topic_key' => 'required|max:50',
        ]);
         
         try {
            $this->model->create($request->all());
         } catch(\Exception $e){
             
             return response()->json(['message' => 'Invalid data!'], 400);
         }
         
         return response()->json(['message' => 'New topic created successfully!']);
        
        
    }
    
    public function update($id, Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'topic_key' => 'required|max:50',
        ]);
        
        if(!$topic = $this->model->find($id)){ //
            
            return response()->json(['message' => "Can't find topic!"], 404);
        }
        
        try {
            $topic->update($request->all());
        } catch (\Exception $e){
            
            return response()->json(['message' => 'Invalid data!'], 400);
        }
        
        return response()->json(['message' => 'Topic updated successfully!']);
    }
    
    
    public function get_subtopics($id){ 
        
        if (!$subtopics= $this->model->find($id)){ 
            
            return response()->json(['message' => "Can't find!"], 404);
        }
        
        $data= $subtopics->subtopics()->get();
        
        return response()->json([$data]);
    }
    
    
    
    public function get_subtopic($id, $subtopic_id, Subtopic $subtopic_model){ 
        
        if(!$subtopic = $subtopic_model->where('id', $subtopic_id)->where('topic_id', $id)->first()){
            
            return response()->json(['message' => "Can't find subtopic!"], 404);
        }
        
        return response()->json([$subtopic]);
    }
    
    
    public function create_subtopic($id, Request $request){ 
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'subtopic_key' => 'required|max:50',
        ]);
        
        if (!$topic = $this->model->find($id)){ 
            
             return response()->json(['message' => "Can't find topic!"], 404); 
        }
        
        try {
            $topic -> subtopics()->create($request->all());
        } catch (\Exception $e){
            
             return response()->json(['message' => "Invalid data!"], 400);
        }
        
        return response()->json(['message' => "Subtopic created successfully!"]);
    }
    
    
    public function update_subtopic($id, $subtopic_id, Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'subtopic_key' => 'required|max:50',
        ]);
        
        if (!$subtopic=Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){
            
            return response()->json(['message' => "Can't find subtopic!"], 404);
        }
        
        try {
        $subtopic->update($request->all());
        } catch (\Exception $e){
            
            return response()->json(['message' => "Invalid data!"], 400);
        }
        
        return response()->json(['message' => "Subtopic updated successfully!"]);
    }
    
    
    public function delete_subtopic($id, $subtopic_id, Subtopic $subtopic){
        
        $this->model=$subtopic;
        
       if (!$find_subtopic= Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){
           
           return response()->json(['message' => "Can't find subtopic!"], 404);
       }
       
       return $subtopic->delete($find_subtopic->id);
        
        
    }
    
    public function add_post_to_topic($id, $post_id, Post $post){
        
        
        $status = Status::where('status_key', 'published')->first();
       
        if (!$model = $post->where('id', $post_id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            $data = $model->topics()->attach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        
         return response()->json(['message' => 'Post added successfully!' ]);
    }
    
    
    public function remove_post_from_topic($id, $post_id, Post $post){
        
        
        $status = Status::where('status_key', 'published')->first();
       
        if (!$model = $post->where('id', $post_id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            $data = $model->topics()->detach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        
         return response()->json(['message' => 'Post removed successfully!' ]);
    }
    
    
    public function add_post_to_subtopic($id, $post_id, Post $post){
        
        
        $status = Status::where('status_key', 'published')->first();
       
        if (!$model = $post->where('id', $post_id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            $data = $model->subtopics()->attach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        
         return response()->json(['message' => 'Post added successfully!' ]);
    }
    
    
    public function remove_post_from_subtopic($id, $post_id, Post $post){
        
        
        $status = Status::where('status_key', 'published')->first();
       
        if (!$model = $post->where('id', $post_id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            $data = $model->subtopics()->detach($id);
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        
         return response()->json(['message' => 'Post removed successfully!' ]);
    }
    
    
    public function get_topic_posts($id){
        
        if(!$model = $this->model->find($id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        $data = $model->posts()->get();
        
        return response()->json([ $data ]);
    }
    
     public function get_subtopic_posts($id, Subtopic $subtopic){
        
        if(!$model = $subtopic->find($id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        $data = $model->posts()->get();
        
        return response()->json(['data' => $data ]);
    }
    
        
}
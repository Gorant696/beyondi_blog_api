<?php

namespace App\Http\Controllers\Topics;

use App\Http\Controllers\BasicController;
use App\Topic;
use App\Subtopic;

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
    
    public function create(Topic $topic, Request $request){
        
         $this->validate($request, [
            'name' => 'required|max:50',
            'topic_key' => 'required|max:50',
        ]);
         
         try {
         $topic->name = $request->input('name');
         $topic->topic_key = $request->input('topic_key');
         $topic->save();
         
         } catch(\Exception $e){
             
             return response()->json(['Message' => 'Invalid data!']);
         }
         
         return response()->json(['Message' => 'New topic created successfully!']);
        
        
    }
    
    public function update($id, Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'topic_key' => 'required|max:50',
        ]);
        
        if(!$topic = Topic::find($id)){
            
            return response()->json(['Message' => "Can't find topic!"]);
        }
        
        try {
            $topic->name = $request->input('name');
            $topic->topic_key = $request->input('topic_key');
            $topic->save();
        
        } catch (\Exception $e){
            
            return response()->json(['Message' => 'Invalid data!']);
        }
        
        return response()->json(['Message' => 'Topic updated successfully!']);
    }
    
    
    public function get_subtopics($id){
        
        if (!$subtopics=Topic::find($id)){
            
            return response()->json(['Message' => "Can't find!"]);
        }
        
        $data= $subtopics->subtopics()->get();
        
        return response()->json(['Message' => $data]);
        
    }
    
    
    
    public function get_subtopic($id, $subtopic_id){
        
        if(!$subtopic = Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){
            
            return response()->json(['Message' => "Can't find subtopic!"]);
            
        }
        
        return response()->json(['Message' => $subtopic]);
    }
    
    
    public function create_subtopic($id, Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'subtopic_key' => 'required|max:50',
        ]);
        
        if (!$topic = Topic::find($id)){
            
             return response()->json(['Message' => "Can't find topic!"]);
        }
        
        try {
            $topic -> subtopics()->create([
                'name'=> $request->input('name'),
                'subtopic_key'=> $request->input('subtopic_key')
            ]);
        } catch (\Exception $e){
            
             return response()->json(['Message' => "Invalid data!"]);
        }
        
        return response()->json(['Message' => "Subtopic created successfully!"]);
    }
}
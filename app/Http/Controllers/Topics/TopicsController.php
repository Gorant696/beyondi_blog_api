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
             //$this->model->create($request->all());
         $topic->name = $request->input('name');
         $topic->topic_key = $request->input('topic_key');
         $topic->save();
         
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
        
        if(!$topic = Topic::find($id)){ //$this->model->find()
            
            return response()->json(['message' => "Can't find topic!"], 404);
        }
        
        try {
            //$this->model->update($request->all());
            $topic->name = $request->input('name');
            $topic->topic_key = $request->input('topic_key');
            $topic->save();
        
        } catch (\Exception $e){
            
            return response()->json(['message' => 'Invalid data!'], 400);
        }
        
        return response()->json(['message' => 'Topic updated successfully!']);
    }
    
    
    public function get_subtopics($id){ //getSubTopics()
        
        if (!$subtopics=Topic::find($id)){ //$this->model
            
            return response()->json(['message' => "Can't find!"], 400);
        }
        
        $data= $subtopics->subtopics()->get();
        
        return response()->json(['message' => $data]);
    }
    
    
    
    public function get_subtopic($id, $subtopic_id /*Subtopic $subtopicModel*/){ //getSubTopic
        
        if(!$subtopic = Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){ //$subtopicModel->where
            
            return response()->json(['message' => "Can't find subtopic!"], 400);
        }
        
        return response()->json(['message' => $subtopic]);
    }
    
    
    public function create_subtopic($id, Request $request){ //ime funkcije
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'subtopic_key' => 'required|max:50',
        ]);
        
        if (!$topic = Topic::find($id)){ //this->model
            
             return response()->json(['Message' => "Can't find topic!"], 400); //malo slovo
        }
        
        try {
            $topic -> subtopics()->create(//$request->all()
            [ 
                'name'=> $request->input('name'),
                'subtopic_key'=> $request->input('subtopic_key')
            ]);
        } catch (\Exception $e){
            
             return response()->json(['Message' => "Invalid data!"], 400);
        }
        
        return response()->json(['Message' => "Subtopic created successfully!"]);
    }
    
    
    public function update_subtopic($id, $subtopic_id, Request $request){
        
        $this->validate($request, [
            'name' => 'required|max:50',
            'subtopic_key' => 'required|max:50',
        ]);
        
        if (!$subtopic=Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){
            
            return response()->json(['Message' => "Can't find subtopic!"]);
        }
        
        try {
        $subtopic->update([
            'name'=>$request->input('name'),
            'subtopic_key'=>$request->input('subtopic_key')
        ]);
        } catch (\Exception $e){
            
            return response()->json(['Message' => "Invalid data!"]);
        }
        
        return response()->json(['Message' => "Subtopic updated successfully!"]);
    }
    
    
    public function delete_subtopic($id, $subtopic_id, Subtopic $subtopic){
        
        $this->model=$subtopic;
        
       if (!$find_subtopic= Subtopic::where('id', $subtopic_id)->where('topic_id', $id)->first()){
           
           return response()->json(['Message' => "Can't find subtopic!"]);
       }
       
       return $subtopic->delete($find_subtopic->id);
        
        
    }
    
        
}
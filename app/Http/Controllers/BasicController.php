<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Topic;
use App\Role;
use App\Tag;
use App\Comment;
use App\Status;
use App\Subscribe;
use App\Subtopic;
use App\Visitor;
use App\Similarpost;
use App\Relatedpost;
use App\Like;

class BasicController extends Controller {

    public $model;

    public function __construct(Model $model) {

        $this->model = $model;
    }

    public function all() {

        $data = $this->model::all();

        return response()->json(['data' => $data]);
    }
    

    public function find($id) {

        if (!$data = $this->model::find($id)) {

            return response()->json(['message' => "Can't find!"]);
        }

        return response()->json(['data' => $data]);
    }
    

    public function delete($id) {

        if (!$this->model::find($id)) {

            return response()->json(['message' => "Can't find!"]);
        }

        try {
            $this->model::destroy($id);

            return response()->json(['message' => "Deleted!"]);
        } catch (\Exception $e) {

            return response()->json(['message' => "Can't delete!"]);
        }
    }
    
    public function attach_post_to_category($id, $post_id, Post $post, $function){
        
        $status = Status::where('status_key', 'published')->first();
       
        if (!$model = $post->where('id', $post_id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            
            if ($function == 'attachtopic'){
            $data = $model->topics()->attach($id);
            } 
            
            if ($function == 'detachtopic'){
                
                $data = $model->topics()->detach($id);
            }
            
            if ($function == 'attachsubtopic'){
            $data = $model->subtopics()->attach($id);
            } 
            
            if ($function == 'detachsubtopic'){
                
                $data = $model->subtopics()->detach($id);
            }
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        
         return response()->json(['message' => 'Post added successfully!' ]);
    }
    
    public function get_category_posts($id){
        
        if(!$model = $this->model->find($id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        $data = $model->posts()->get();
        
        return response()->json([$data]);
    }

}

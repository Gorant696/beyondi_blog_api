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

            return response()->json(['message' => "Can't find!"], 404);
        }

        return response()->json(['data' => $data]);
    }
    

    public function delete($id) {

        if (!$this->model::find($id)) {

            return response()->json(['message' => "Can't find!"], 404);
        }

        try {
            $this->model::destroy($id);

            return response()->json(['message' => "Deleted!"]);
        } catch (\Exception $e) {

            return response()->json(['message' => "Can't delete!"], 400);
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
        
         return response()->json(['message' => 'Done!' ]);
    }
    
    public function get_category_posts($id){
        
        if(!$model = $this->model->find($id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        $data = $model->posts()->get();
        
        return response()->json([$data]);
    }
    
    public function get_post_subresources($id, $function){
        
        if (!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        switch ($function){
            
            case 'visitors':
                $data = $model->visitors()->get(); break;
        
            case 'comments':
                $data = $model->comments()->get(); break;
        
            case 'relatedpsots':
                $data = $model->relatedposts()->get(); break;
        
            case 'similarposts':
                $data = $model->similarposts()->get(); break;
        
            case 'tags':
                $data = $model->tags()->get(); break;
        }
        
        return response()->json(['message' => $data]); 
    }
    
    public function related_similar_posts($id, $post_id, $function){
        
         if (!$model = $this->model->find($id)){
            
            return response()->json(['message' => "Can't find!"], 404); 
        }
        
        if ($function == 'relatedpost'){
            if (!$data= $model->relatedposts()->where('relatedpost_id', $post_id)->first()){

                return response()->json(['message' => "Can't find!"], 404); 
            }
        }
        
         if ($function == 'similarpost'){
            if (!$data= $model->similarposts()->where('similarpost_id', $post_id)->first()){

                return response()->json(['message' => "Can't find!"], 404); 
            }
        }

        return response()->json([$data]);
    }
    
    public function create_related_similar($post_id, $request, $validation_column){
        
        $this->validate($request, [
            $validation_column => 'required'
        ]);
        
         if (!$post = $this->model->find($post_id)){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404);
        }
        
        try {
            
            if ($validation_column == 'relatedpost_id'){
                $post->relatedposts()->create([
                    'post_id'=>$post_id,
                    'relatedpost_id'=>$request->input('relatedpost_id')
                ]);
            }
            
            if ($validation_column == 'similarpost_id'){
                $post->similarposts()->create([
                    'post_id'=>$post_id,
                    'similarpost_id'=>$request->input('similarpost_id')
                ]);
            }
        } catch (\Exception $e){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 400);
        }
        return response()->json(['message' => "Done!"]);
        
    }
    
    public function tag_control($id, $post_id, $function){
        
          if (!$model =$this->model->find($post_id)){
            
           return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        try {
            
            if ($function == 'attach'){
                $model->tags()->attach($id);
            }
            
            if ($function == 'detach'){
                $model->tags()->detach($id);
            }
        } catch (\Exception $e){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 400); 
        }
        
         return response()->json(['message' => "Done!"]); 
    }

}

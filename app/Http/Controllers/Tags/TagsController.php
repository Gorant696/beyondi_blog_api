<?php

namespace App\Http\Controllers\Tags;


use App\Http\Controllers\BasicController;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class TagsController extends BasicController {

  
    public function __construct(Tag $tag) {
        
        $this->model = $tag;
     
    }
    
    public function create(Request $request){
        
       $this->validate($request, [
            'tag_name' => 'required|max:20',
        ]);
       
       try {
            $this->model->create($request->all());
            
            return response()->json(['message'=> 'Tag added!']);
            
       } catch (\Exception $e){
           
           return response()->json(['message'=>'Tag already exists!'], 400);
       }

        
    }
    
    public function get_posts($id){
        
        if(!$tag_posts = $this->model->with('posts')->where('id', $id)->first()){
            
            return response()->json(['message'=>"Can't find tag"], 404);
            
        }
        
        return response()->json([$tag_posts]);
        
    }
    
    
    

}
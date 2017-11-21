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
    
    public function create(Tag $tag, Request $request){
        
       $this->validate($request, [
            'tag_name' => 'required|max:20',
        ]);
       
       try {
            $tag->name = $request->input('tag_name');
            $tag->save();
            
            return response()->json(['message'=> 'Tag added!']);
            
       } catch (\Exception $e){
           
           return response()->json(['message'=>'Tag already exists!']);
       }

        
    }
    
    public function get_posts($id){
        
        if(!$tag_posts = Tag::with('posts')->where('id', $id)->first()){
            
            return response()->json(['message'=>"Can't find tag"]);
            
        }
        
        return response()->json(['data' => $tag_posts]);
        
    }
    
    
    

}
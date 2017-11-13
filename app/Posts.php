<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {
    
    public function users(){
        
       return $this->belongsto(User::class);
        
    }
    
    public function comments(){
        
        return $this->hasmany(Comments::class);
        
    }
    
    public function tags(){
        
        return $this->belongstomany(Tags::class, 'post_tags', 'post_id', 'tag_id');
        
    }
    
    public function subtopics(){
        
        return $this->belongsto(Subtopics::class);
        
    }
    
    public function visitors(){
        
        return $this->belongstomany(User::class, 'visitors', 'post_id', 'user_id');
        
    }
    
}

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
    
    public function topics(){
        
        return $this->belongsto(Topics::class);
        
    }
    

    
    public function status(){
        
        return $this->hasone(Status::class);
        
    }
    
    public function relatedposts(){
        
        return $this->belongstomany(Posts::class, 'relatedposts', 'post_id', 'related_post_id');
        
    }
    
    public function similarposts(){
        
        return $this->belongstomany(Posts::class, 'similarposts', 'post_id', 'similar_post_id');
        
    }
    
    public function visitors(){
        
        return $this->hasmany(Visitors::class);
        
    }
    
    
    
}

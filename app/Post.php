<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    
    public function users(){
        
       return $this->belongsto(User::class, 'user_id');
        
    }
    
    public function comments(){
        
        return $this->hasmany(Comment::class);
        
    }
    
    public function tags(){
        
        return $this->belongstomany(Tag::class, 'post_tags', 'post_id', 'tag_id');
        
    }
    
    public function subtopics(){
        
        return $this->belongstomany(Subtopic::class, 'subtopic_posts', 'post_id', 'subtopic_id');
        
    }
    
    public function topics(){
        
        return $this->belongstomany(Topic::class, 'topic_posts', 'post_id', 'topic_id');
        
    }
    

    
    public function status(){
        
        return $this->belongsto(Status::class, 'status_id');
        
    }
    
    
    public function visitors(){
        
        return $this->hasmany(Visitor::class);
        
    }
    
    public function relatedposts(){
        
        return $this->hasmany(Relatedpost::class);
        
    }
    
      public function similarposts(){
        
        return $this->hasmany(Similarpost::class);
        
    }
    
  
    
    

    
    
    
}

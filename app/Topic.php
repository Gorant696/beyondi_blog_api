<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    
    public $timestamps = false;
    
    public function subtopics(){
        
        return $this->hasmany(Subtopic::class);
        
    }
    
    public function posts(){
        
        return $this->belongstomany(Post::class, 'topic_posts', 'topic_id', 'post_id');
        
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model {
    
    public $timestamps = false;
     protected $fillable = ['subtopic_key', 'name'];
    
    public function topics(){
        
        return $this->belongsto(Topic::class, 'topic_id');
        
    }
    
    public function posts(){
        
        return $this->belongstomany(Post::class, 'subtopic_posts', 'subtopic_id', 'post_id');
        
    }
    
}

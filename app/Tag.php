<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    
     public $timestamps = false;
    
    public function posts(){
        
        return $this->belongstomany(Post::class, 'post_tags', 'tag_id', 'post_id');
        
    }
    
}

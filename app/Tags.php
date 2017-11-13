<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model {
    
    public function posts(){
        
        return $this->belongstomany(Posts::class, 'post_tags', 'tag_id', 'post_id');
        
    }
    
}

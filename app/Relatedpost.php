<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Relatedpost extends Model {
    
     public function posts(){
        
        return $this->belongsto(Post::class, 'post_id');
        
    }
    
}

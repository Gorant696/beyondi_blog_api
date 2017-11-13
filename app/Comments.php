<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model {
    
     public function posts(){
        
        return $this->belongsto(Posts::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
    public function likes(){
        
        return $this->belongstomany(User::class, 'likes', 'comment_id', 'user_id');
        
    }
    
}

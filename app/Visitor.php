<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model {
    
    public function posts(){
        
        return $this->belongsto(Post::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
    
}

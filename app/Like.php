<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
    

    public function comments(){
        
        return $this->belongsto(Comment::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
}

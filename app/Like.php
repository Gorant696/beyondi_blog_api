<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
    

    public function comments(){
        
        return $this->belongsto(Comment::class, 'comment_id');
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class, 'user_id');
        
    }
    
}

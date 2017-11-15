<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model {
    

    public function comments(){
        
        return $this->belongsto(Comments::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
}

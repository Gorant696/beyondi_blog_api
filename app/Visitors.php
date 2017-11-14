<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model {
    
    public function posts(){
        
        return $this->belongsto(Posts::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtopics extends Model {
    
    public $timestamps = false;
    
    public function topics(){
        
        return $this->belongsto(Topics::class);
        
    }
    
    public function posts(){
        
        return $this->hasmany(Posts::class);
        
    }
    
}

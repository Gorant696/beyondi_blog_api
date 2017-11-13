<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model {
    
    public $timestamps = false;
    
    public function subtopics(){
        
        return $this->hasmany(Subtopics::class);
        
    }
    
}

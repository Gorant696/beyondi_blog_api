<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model {
    
      public $timestamps = false;
      protected $fillable = ['user_id', 'ip_adress'];
    
    public function posts(){
        
        return $this->belongsto(Post::class);
        
    }
    
    public function users(){
        
        return $this->belongsto(User::class);
        
    }
    
    
}

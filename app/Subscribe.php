<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model {
    
      public $timestamps = false;
      protected $fillable = ['user_id', 'subscribable_id', 'subscribable_type'];
    
       public function subscribable() {
           
        return $this->morphTo();
    }
    
    public function users(){
        
        return $this->belongsto(User::class, 'user_id');
    }
    
     
    
 
    
    
}

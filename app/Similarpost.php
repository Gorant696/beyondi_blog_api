<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Similarpost extends Model {
    
    protected $fillable = [ 'similarpost_id', 'post_id'];
    
     public function posts(){
        
        return $this->belongsto(Post::class, 'post_id');
        
    }
    
}
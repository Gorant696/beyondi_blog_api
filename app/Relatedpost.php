<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Relatedpost extends Model {
    
    protected $fillable = [ 'relatedpost_id', 'post_id'];
    
     public function posts(){
        
        return $this->belongsto(Post::class, 'post_id');
        
    }
    
}

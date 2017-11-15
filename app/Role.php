<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    
    public $timestamps = false;
    
    public function users(){
        
        return $this->belongstomany(User::class, 'user_roles', 'role_id', 'user_id');
        
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    
    public function users(){
        
        return $this->belongstomany(Roles::class, 'user_roles', 'role_id', 'user_id');
        
    }
    
}

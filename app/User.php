<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'fb_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    public function comments(){
        
        return $this->hasmanythrough(Comment::class, Post::class);
        
    }
    
    public function posts(){
        
        return $this->hasmany(Post::class);
        
    }
    
    public function roles(){
        
        return $this->belongstomany(Role::class, 'user_roles', 'user_id', 'role_id');
        
    }
    
    
    public function visitors(){
        
        return $this->hasmany(Visitor::class);
        
    }
    
    public function likes(){
        
        return $this->hasmany(Like::class);
        
    }
    
    public function subscribes(){
        
        return $this->morphMany(Subscribe::class, 'subscribable');
    }
    
  
    
    
    
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socialaccount extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'fb_id'
    ];
    //
}

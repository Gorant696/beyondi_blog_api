<?php

namespace App\Http\Controllers;

use \App\User;

class PageController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('authrole');

     
    }
    
    public function test(){
        
        return "hello";
        
    }


}

<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
        

         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

        
    
}); //end route  group (middleware auth/authrole)


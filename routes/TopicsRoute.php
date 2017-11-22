<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
    $router->get('/topics', 'TopicsController@all');
    
    $router->get('/topics/{id}', 'TopicsController@find');
   
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

     $router->delete('/topics/{id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@delete'
    ]);
     
     $router->post('/topics', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@create'
    ]);
     
         
        
    
}); //end route  group (middleware auth/authrole)



//public routes
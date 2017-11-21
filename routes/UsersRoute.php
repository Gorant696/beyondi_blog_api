<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
        
    
      $router->get('/users', 'UsersController@all');
        
      $router->get('/users/{id}', 'UsersController@find');
      
      $router->get('/users/{id}/posts', 'UsersController@get_posts');
      
      $router->get('/users/{id}/posts/{post_id}', 'UsersController@get_post');
             
   
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    
        $router->put('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UserController@update'
    ]);
  
        $router->delete('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UserController@delete'
    ]);
         
        
    
}); //end route  group (middleware auth/authrole)

$router->post('/users', 'UserController@create');
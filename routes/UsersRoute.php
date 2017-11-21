<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
      $router->get('/users', 'UserController@all');  

      $router->get('/users/{id}', 'UserController@find');
    
      $router->get('/users/{id}/posts', 'UsersController@get_posts');
      
      $router->get('/users/{id}/posts/{post_id}', 'UsersController@get_post');
      
      $router->post('/users/posts', 'UsersController@create_post');
      
      $router->put('/users/{id}', 'UserController@update');
             
   
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

        $router->delete('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UserController@delete'
    ]);
         
        
    
}); //end route  group (middleware auth/authrole)

$router->post('/users', 'UserController@create');
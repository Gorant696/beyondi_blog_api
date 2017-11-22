<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
      $router->get('/users', 'UsersController@all');  

      $router->get('/users/{id}', 'UsersController@find');
    
      $router->get('/users/{id}/posts', 'UsersController@get_posts');
      
      $router->get('/users/{id}/posts/{post_id}', 'UsersController@get_post');
      
      $router->post('/users/posts', 'UsersController@create_post');
      
      $router->put('/users/{id}', 'UsersController@update');
      
      $router->put('/users/{id}/posts/{post_id}', 'UsersController@update_post');
      
      $router->delete('/users/{id}/posts/{post_id}', 'UsersController@delete_post');
      
      $router->get('/users/{id}/visitors', 'UsersController@get_visits');
      
      $router->get('/users/{id}/comments', 'UsersController@get_comments');
             
   
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

        $router->delete('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UsersController@delete'
    ]);
         
        
    
}); //end route  group (middleware auth/authrole)

$router->post('/users', 'UsersController@create');
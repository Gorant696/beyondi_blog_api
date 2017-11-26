<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
      $router->get('/users', 'UsersController@all');  

      $router->get('/users/{id}', 'UsersController@find');
    
      $router->post('/users/posts', 'UsersController@create_post');
      
      $router->get('/users/{id}/visitors', 'UsersController@get_visits');
      
      $router->get('/users/{id}/comments', 'UsersController@get_comments');
      
      $router->get('/users/{id}/roles', 'UsersController@get_roles');
      
      $router->get('/users/{id}/published_posts', 'UsersController@get_published_posts');
             
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

        $router->delete('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UsersController@delete'
    ]);
        
        $router->post('/users/{id}/add_role', [
            'roles' => ['admin'],
            'uses' => 'UsersController@add_role_to_user'
    ]);
        
        $router->delete('/users/{id}/remove_role', [
            'roles' => ['admin'],
            'uses' => 'UsersController@remove_role_to_user'
    ]);
         
}); //end route  group (middleware auth/authrole)

$router->group(['middleware' => ['auth', 'admin_auth']], function () use ($router) {
    

        $router->get('/users/{id}/posts/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@get_post'
    ]);
        
        $router->put('/users/{user_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@update'
    ]);
        
        $router->get('/users/{user_id}/posts', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@get_posts'
    ]);
        
        $router->delete('/users/{id}/posts/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@delete_post'
    ]);
        
        $router->put('/users/{id}/posts/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@update_post'
    ]);
        
        $router->get('/users/{user_id}/draft_posts', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@get_draft_posts'
    ]);
        
        $router->get('/users/{user_id}/unpublished_posts', [
            'roles' => ['admin', 'user'],
            'uses' => 'UsersController@get_unpublished_posts'
    ]);
        
        
        
    
    
}); //end route  group (middleware auth/authrole)

$router->post('/users', 'UsersController@create');
<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
   $router->get('/posts/{id}/visitors', 'PostsController@get_visitors');
   
   $router->get('/posts/{id}/comments', 'PostsController@get_comments');
   
   $router->get('/posts/{id}/comments/{comment_id}', 'PostsController@get_comment');
   
   $router->get('/posts/{id}/relatedposts', 'PostsController@get_relatedposts');
   
   $router->get('/posts/{id}/relatedposts/{relatedpost_id}', 'PostsController@get_relatedpost');
   
   $router->get('/posts/{id}/similarposts', 'PostsController@get_similarposts');
   
   $router->get('/posts/{id}/similarposts/{similarpost_id}', 'PostsController@get_similarpost');
   
   $router->post('/posts/{id}/comments', 'PostsController@create_comment');

         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    


    
}); //end route  group (middleware auth/authrole)

$router->group(['middleware' => ['auth', 'admin_auth']], function () use ($router) {
    
        $router->delete('/posts/{post_id}/visitors', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@delete_visitors'
    ]);
        
        $router->delete('/posts/{id}/comments/{comment_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@delete_comment'
    ]);
        
        $router->delete('/posts/{post_id}/relatedposts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@delete_relatedpost'
    ]);
        
        $router->delete('/posts/{post_id}/similarposts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@delete_similarpost'
    ]);
        
        $router->post('/posts/{post_id}/relatedposts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@create_relatedpost'
    ]);


    
}); //end route  group (middleware auth/authrole)


//public routes



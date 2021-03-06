<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
   $router->get('/posts/{id}/visitors', 'PostsController@get_visitors');
   
   $router->get('/posts/{id}/comments', 'PostsController@get_comments');
   
   $router->get('/posts/{id}/comments/{comment_id}', 'PostsController@get_comment');
   
   $router->get('/posts/{id}/relatedposts', 'PostsController@get_relatedposts');
   
   $router->get('/posts/{id}/relatedposts/{post_id}', 'PostsController@get_relatedpost');
   
   $router->get('/posts/{id}/similarposts', 'PostsController@get_similarposts');
   
   $router->get('/posts/{id}/similarposts/{post_id}', 'PostsController@get_similarpost');
   
   $router->post('/posts/{id}/comments', 'PostsController@create_comment');
   
   $router->get('/posts/{id}/get_tags', 'PostsController@get_tags');
   
   $router->get('/posts/{id}/get_subscribes', 'PostsController@get_subscribes');

         
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
        
        $router->post('/posts/{post_id}/relatedposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@create_relatedpost'
    ]);
        
        $router->post('/posts/{post_id}/similarposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@create_similarpost'
    ]);
        
        $router->put('/posts/{id}/comments/{comment_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@update_comment'
    ]);
        
        $router->post('/posts/{post_id}/attach_tag/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@attach_tag'
    ]);
        
        $router->delete('/posts/{post_id}/remove_tag/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@detach_tag'
    ]);
        
        
    



    
}); //end route  group (middleware auth/authrole)


//public routes



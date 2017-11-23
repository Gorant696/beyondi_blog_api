<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
   $router->get('/posts/{id}/visitors', 'PostsController@get_visitors');
   
   $router->get('/posts/{id}/comments', 'PostsController@get_comments');
   
   $router->get('/posts/{id}/comments/{comment_id}', 'PostsController@get_comment');
   
   $router->get('/posts/{id}/relatedposts', 'PostsController@get_relatedposts');

         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    


    
}); //end route  group (middleware auth/authrole)

$router->group(['middleware' => ['auth', 'admin_auth']], function () use ($router) {
    


    
}); //end route  group (middleware auth/authrole)


//public routes



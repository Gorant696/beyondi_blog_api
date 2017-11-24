<?php

 $router->group(['middleware' => 'auth'], function () use ($router) {
    
        $router->get('/comments/{id}/likes', 'CommentsController@get_likes');

        $router->post('/comments/{id}/likes', 'CommentsController@create_like');
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    


    
}); //end route  group (middleware auth/authrole)

$router->group(['middleware' => ['auth', 'admin_auth']], function () use ($router) {
    
        $router->delete('/comments/{id}/likes/{like_id}', [
                'roles' => ['admin', 'user'],
                'uses' => 'CommentsController@delete_like'
        ]);

}); //end route  group (middleware auth/authrole)


//public routes



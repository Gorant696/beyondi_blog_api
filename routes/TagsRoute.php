<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
    $router->post('/tags', 'TagsController@create');
    
    $router->get('/tags/{id}/posts', 'TagsController@get_posts');

         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    
    
      $router->delete('/tags/{id}', [
            'roles' => ['admin'],
            'uses' => 'TagsController@delete'
    ]);
    
    
}); //end route  group (middleware auth/authrole)


//public routes

$router->get('/tags', 'TagsController@all');

$router->get('/tags/{id}', 'TagsController@find');

<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
    $router->get('/roles/{id}/users', 'RolesController@get_users');

         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    
     $router->delete('/roles/{id}', [
            'roles' => ['admin'],
            'uses' => 'RolesController@delete'
    ]);
     
     $router->post('/roles', [
            'roles' => ['admin'],
            'uses' => 'RolesController@create'
    ]);
     
     $router->put('/roles/{id}', [
            'roles' => ['admin'],
            'uses' => 'RolesController@update'
    ]);

    
}); //end route  group (middleware auth/authrole)


//public routes

$router->get('/roles', 'RolesController@all');

$router->get('/roles/{id}', 'RolesController@find');

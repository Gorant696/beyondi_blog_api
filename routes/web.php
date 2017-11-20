<?php



//Rute za koje je potrebno biti prijavljen

$router->group(['middleware' => 'auth'], function () use ($router) {
    
        $router->get('/users', [
            'uses' => 'UserController@all'
    ]);
        
        $router->get('/users/{id}', [
            'uses' => 'UserController@finduser'
    ]);
             
        
        $router->get('/logout', [
            'uses' => 'MyController@logoutuser'
    ]);
         
}); //end route group




//Rute za koje je bitno biti prijavljen i određene role

$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    
        $router->put('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UserController@update'//metoda kontrolera
    ]);
  
        $router->delete('/users/{id}', [
            'roles' => ['admin'],
            'uses' => 'UserController@delete'//metoda kontrolera
    ]);
         
        
    
}); //end route groupe




//Rute kojima može bilo tko pristupiti

$router->get('/', 'AuthController@index');

$router->post('/login', 'AuthController@login');

$router->post('/users', 'UserController@create');












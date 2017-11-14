<?php



//Rute za koje je potrebno biti prijavljen
$router->group(['middleware' => 'auth'], function () use ($router) {
    
     $router->get('/users', [
        'roles' => ['admin', 'user'],
        'uses' => 'UserController@all'//metoda kontrolera
    ]);
     
        $router->get('/users/{id}', [
        'roles' => ['admin', 'user'],
        'uses' => 'UserController@finduser'//metoda kontrolera
    ]);
        
             $router->get('/logout', [
        'roles' => ['admin', 'user'],
        'uses' => 'UserController@logoutuser'//metoda kontrolera
    ]);
    
});

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
    
});


//Rute kojima može bilo tko pristupiti
$router->get('/', 'AuthController@index');

$router->post('/login', 'AuthController@login');

$router->post('/users', 'UserController@create');

$router->get('/posts', 'PostsController@all');




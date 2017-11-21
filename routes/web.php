<?php


$namespace_array=[
    'Users'=>'UsersRoute.php',
    'Tags' =>'TagsRoute.php', 
    'Roles' =>'RolesRoute.php'
    ];

foreach ($namespace_array as $namespace =>$path){
    
    $router->group(['namespace' => $namespace], function () use ($router, $path) {
    
        require $path;
        
}); //end route group
    
}


//Public routes

$router->get('/', 'AuthController@index');

$router->post('/login', 'AuthController@login');

$router->get('/logout', 'MyController@logoutuser');









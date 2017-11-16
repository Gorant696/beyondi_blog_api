<?php



//Rute za koje je potrebno biti prijavljen

$router->group(['middleware' => 'auth'], function () use ($router) {
    
        $router->get('/users', [
            'uses' => 'UserController@all'
    ]);
        
        $router->get('/users/{id}', [
            'uses' => 'UserController@finduser'
    ]);
             
        $router->get('/posts', [
            'uses' => 'PostsController@all'
    ]);
        
        $router->get('/posts/{id}', [
            'uses' => 'PostsController@findpost'
    ]);
        
        $router->post('/posts', [
            'uses' => 'PostsController@create'
    ]);
        
        $router->get('/comments', [
            'uses' => 'CommentsController@all'
    ]);
        
        $router->get('/comments/{id}', [
            'uses' => 'CommentsController@findcomment'
    ]);
        
        $router->post('/comments', [
            'uses' => 'CommentsController@create'
    ]);
        
        $router->get('/likes', [
            'uses' => 'LikesController@all'
    ]);
        
        $router->get('/likes/{id}', [
            'uses' => 'LikesController@findlike'
    ]);
        
        $router->post('/likes', [
            'uses' => 'LikesController@create'
    ]);
        
        $router->get('/relatedposts', [
            'uses' => 'RelatedpostsController@all'
    ]);
        
        $router->get('/relatedposts/{id}', [
            'uses' => 'RelatedpostsController@findrelatedpost'
    ]);
        
        $router->post('/relatedposts', [
            'uses' => 'RelatedpostsController@create'
    ]);
        
        $router->get('/similarposts', [
            'uses' => 'SimilarpostsController@all'
    ]);
        
        $router->get('/similarposts/{id}', [
            'uses' => 'SimilarpostsController@findsimilarpost'
    ]);
        
        $router->post('/similarposts', [
            'uses' => 'SimilarpostsController@create'
    ]);
        
        $router->get('/status', [
            'uses' => 'StatusController@all'
    ]);
        
        $router->get('/status/{id}', [
            'uses' => 'StatusController@findstatus'
    ]);
        
        $router->get('/subtopics', [
            'uses' => 'SubtopicsController@all'
    ]);
        
        $router->get('/subtopics/{id}', [
            'uses' => 'SubtopicsController@findsubtopic'
    ]);
        
        $router->get('/tags', [
            'uses' => 'TagsController@all'
    ]);
        
        $router->get('/tags/{id}', [
            'uses' => 'TagsController@findtag'
    ]);
        
        $router->post('/tags', [
            'uses' => 'TagsController@create'
    ]);
        
        $router->get('/topics', [
            'uses' => 'TopicsController@all'
    ]);
        
        $router->get('/topics/{id}', [
            'uses' => 'TopicsController@findtopic'
    ]);
        
        $router->get('/visitors', [
            'uses' => 'VisitorsController@all'
    ]);
        
        $router->get('/visitors/{id}', [
            'uses' => 'VisitorsController@findvisitor'
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
         
        $router->put('/posts/{id}', [
            'roles' => ['admin'],
            'uses' => 'PostsController@update'
    ]);
        
        $router->delete('/posts/{id}', [
            'roles' => ['admin'],
            'uses' => 'PostsController@delete'
    ]);
        
        $router->put('/comments/{id}', [
            'roles' => ['admin'],
            'uses' => 'CommentsController@update'
    ]);
        
        $router->delete('/comments/{id}', [
            'roles' => ['admin'],
            'uses' => 'CommentsController@delete'
    ]);
        
        $router->put('/likes/{id}', [
            'roles' => ['admin'],
            'uses' => 'LikesController@update'
    ]);
        
        $router->delete('/likes/{id}', [
            'roles' => ['admin'],
            'uses' => 'LikesController@delete'
    ]);
        
        $router->put('/relatedposts/{id}', [
            'roles' => ['admin'],
            'uses' => 'RelatedpostsController@update'
    ]);
        
        $router->delete('/relatedposts/{id}', [
            'roles' => ['admin'],
            'uses' => 'RelatedpostsController@delete'
    ]);
        
        $router->get('/roles', [
            'roles' => ['admin'],
            'uses' => 'RolesController@all'
    ]);
        
        $router->get('/roles/{id}', [
            'roles' => ['admin'],
            'uses' => 'RolesController@findrole'
    ]);
        
        $router->post('/roles', [
            'roles' => ['admin'],
            'uses' => 'RolesController@create'
    ]);
        
        $router->put('/roles/{id}', [
            'roles' => ['admin'],
            'uses' => 'RolesController@update'
    ]);
        
        $router->delete('/roles', [
            'roles' => ['admin'],
            'uses' => 'RolesController@delete'
    ]);
        
        $router->put('/addrole', [
            'roles' => ['admin'],
            'uses' => 'RolesController@AddRoleToUser'
    ]);
        
        $router->put('/removerole', [
            'roles' => ['admin'],
            'uses' => 'RolesController@RemoveRoleFromUser'
    ]);
        
        $router->put('/similarposts/{id}', [
            'roles' => ['admin'],
            'uses' => 'SimilarpostsController@update'
    ]);
        
        $router->delete('/similarposts/{id}', [
            'roles' => ['admin'],
            'uses' => 'SimilarpostsController@delete'
    ]);
        
        $router->post('/status', [
            'roles' => ['admin'],
            'uses' => 'StatusController@create'
    ]);
        
        $router->put('/status/{id}', [
            'roles' => ['admin'],
            'uses' => 'StatusController@update'
    ]);
        
        $router->delete('/status/{id}', [
            'roles' => ['admin'],
            'uses' => 'StatusController@delete'
    ]);
        
        $router->post('/subtopics', [
            'roles' => ['admin'],
            'uses' => 'SubtopicsController@create'
    ]);
        
        $router->put('/subtopics/{id}', [
            'roles' => ['admin'],
            'uses' => 'SubtopicsController@update'
    ]);
        
        $router->delete('/subtopics/{id}', [
            'roles' => ['admin'],
            'uses' => 'SubtopicsController@delete'
    ]);
        
        $router->put('/tags/{id}', [
            'roles' => ['admin'],
            'uses' => 'TagsController@update'
    ]);
        
        $router->delete('/tags/{id}', [
            'roles' => ['admin'],
            'uses' => 'TagsController@delete'
    ]);
        
        $router->post('/topics', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@create'
    ]);
        
        $router->put('/topics/{id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@update'
    ]);
        
        $router->delete('/topics/{id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@delete'
    ]);
        
        $router->post('/visitors', [
            'roles' => ['admin'],
            'uses' => 'VisitorsController@create'
    ]);
        
        $router->put('/visitors/{id}', [
            'roles' => ['admin'],
            'uses' => 'VisitorsController@update'
    ]);
        
        $router->delete('/visitors/{id}', [
            'roles' => ['admin'],
            'uses' => 'VisitorsController@delete'
    ]);
        
    
}); //end route groupe



//Rute kojima može bilo tko pristupiti

$router->get('/', 'AuthController@index');

$router->post('/login', 'AuthController@login');

$router->post('/users', 'UserController@create');












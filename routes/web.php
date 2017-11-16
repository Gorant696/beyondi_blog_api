<?php



//Rute za koje je potrebno biti prijavljen

$router->group(['middleware' => 'auth'], function () use ($router) {
    
        $router->get('/users', [
            'roles' => ['admin', 'user'],
            'uses' => 'UserController@all'
    ]);
     
        $router->get('/users/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'UserController@finduser'
    ]);
        
        $router->get('/logout', [
            'roles' => ['admin', 'user'],
            'uses' => 'MyController@logoutuser'
    ]);
             
        $router->get('/posts', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@all'
    ]);
        
        $router->get('/posts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@findpost'
    ]);
        
        $router->post('/posts', [
            'roles' => ['admin', 'user'],
            'uses' => 'PostsController@create'
    ]);
        
        $router->get('/comments', [
            'roles' => ['admin', 'user'],
            'uses' => 'CommentsController@all'
    ]);
        
        $router->get('/comments/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'CommentsController@findcomment'
    ]);
        
        $router->post('/comments', [
            'roles' => ['admin', 'user'],
            'uses' => 'CommentsController@create'
    ]);
        
        $router->get('/likes', [
            'roles' => ['admin', 'user'],
            'uses' => 'LikesController@all'
    ]);
        
        $router->get('/likes/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'LikesController@findlike'
    ]);
        
        $router->post('/likes', [
            'roles' => ['admin', 'user'],
            'uses' => 'LikesController@create'
    ]);
        
        $router->get('/relatedposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'RelatedpostsController@all'
    ]);
        
        $router->get('/relatedposts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'RelatedpostsController@findrelatedpost'
    ]);
        
        $router->post('/relatedposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'RelatedpostsController@create'
    ]);
        
        $router->get('/similarposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'SimilarpostsController@all'
    ]);
        
        $router->get('/similarposts/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'SimilarpostsController@findsimilarpost'
    ]);
        
        $router->post('/similarposts', [
            'roles' => ['admin', 'user'],
            'uses' => 'SimilarpostsController@create'
    ]);
        
        $router->get('/status', [
            'roles' => ['admin', 'user'],
            'uses' => 'StatusController@all'
    ]);
        
        $router->get('/status/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'StatusController@findstatus'
    ]);
        
        $router->get('/subtopics', [
            'roles' => ['admin', 'user'],
            'uses' => 'SubtopicsController@all'
    ]);
        
        $router->get('/subtopics/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'SubtopicsController@findsubtopic'
    ]);
        
        $router->get('/tags', [
            'roles' => ['admin', 'user'],
            'uses' => 'TagsController@all'
    ]);
        
        $router->get('/tags/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TagsController@findtag'
    ]);
        
        $router->post('/tags', [
            'roles' => ['admin', 'user'],
            'uses' => 'TagsController@create'
    ]);
        
        $router->get('/topics', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@all'
    ]);
        
        $router->get('/topics/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@findtopic'
    ]);
        
        $router->get('/visitors', [
            'roles' => ['admin', 'user'],
            'uses' => 'VisitorsController@all'
    ]);
        
        $router->get('/visitors/{id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'VisitorsController@findvisitor'
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
        
    
});



//Rute kojima može bilo tko pristupiti

$router->get('/', 'AuthController@index');

$router->post('/login', 'AuthController@login');

$router->post('/users', 'UserController@create');

$router->get('/ip', 'PostsController@test');










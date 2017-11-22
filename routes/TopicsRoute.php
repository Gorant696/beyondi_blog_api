<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
  
   
         
}); //end route group (middleware auth)


$router->group(['middleware' => ['auth', 'authrole']], function () use ($router) {
    

     $router->delete('/topics/{id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@delete'
    ]);
     
     $router->post('/topics', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@create'
    ]);
     
     $router->put('/topics/{id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@update'
    ]);
     
      $router->post('/topics/{id}/subtopics', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@create_subtopic'
    ]);
      
      $router->put('/topics/{id}/subtopics/{subtopic_id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@update_subtopic'
    ]);
      
      $router->delete('/topics/{id}/subtopics/{subtopic_id}', [
            'roles' => ['admin'],
            'uses' => 'TopicsController@delete_subtopic'
    ]);
     
         
        
    
}); //end route  group (middleware auth/authrole)



//public routes

  $router->get('/topics', 'TopicsController@all');
    
  $router->get('/topics/{id}', 'TopicsController@find');
  
  $router->get('topics/{id}/subtopics', 'TopicsController@get_subtopics');
  
  $router->get('topics/{id}/subtopics/{subtopic_id}', 'TopicsController@get_subtopic');
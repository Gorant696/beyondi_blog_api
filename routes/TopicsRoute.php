<?php

$router->group(['middleware' => 'auth'], function () use ($router) {
    
    $router->get('/topics/{id}/published_posts', 'TopicsController@get_topic_posts');
    
    $router->get('/subtopics/{id}/published_posts', 'TopicsController@get_subtopic_posts');
   
         
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

$router->group(['middleware' => ['auth', 'admin_auth']], function () use ($router) {
    
        $router->post('/topics/{id}/add_post/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@add_post_to_topic'
    ]);
        
        $router->delete('/topics/{id}/remove_post/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@remove_post_from_topic'
    ]);
        
        $router->post('/subtopics/{id}/add_post/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@add_post_to_subtopic'
    ]);
        
        $router->delete('/subtopics/{id}/remove_post/{post_id}', [
            'roles' => ['admin', 'user'],
            'uses' => 'TopicsController@remove_post_from_subtopic'
    ]);
   
         
}); //end route group (middleware auth)



//public routes

  $router->get('/topics', 'TopicsController@all');
    
  $router->get('/topics/{id}', 'TopicsController@find');
  
  $router->get('topics/{id}/subtopics', 'TopicsController@get_subtopics');
  
  $router->get('topics/{id}/subtopics/{subtopic_id}', 'TopicsController@get_subtopic');
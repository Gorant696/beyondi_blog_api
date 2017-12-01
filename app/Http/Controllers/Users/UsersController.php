<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BasicController;
use \App\User;
use \App\Role;
use \App\Post;
use \App\Status;
use \App\Visitor;
use \App\Subscribe;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;

class UsersController extends BasicController {
    
    
      public function __construct(User $user) {
        
        $this->model = $user;
     
    }
    
    static protected function slug($text) {
        
        
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        $text = preg_replace('~[^-\w]+~', '', $text);

        $text = trim($text, '-');

        $text = preg_replace('~-+~', '-', $text);

        $text = strtolower($text);

        return $text;
}

    public function create(Request $request, User $user) {

        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|max:20',
                //u input treba staviti "password_confirmation" inputi u njemu ponoviti lozinku
        ]);
        
        $roles = Role::where('role_key', env('DEFAULT_USER_ROLE'))->first();
        $pass = $request->input('password');

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = app('hash')->make($pass);
        $user->save();
        $user->roles()->attach($roles->id);

        return response()->json(['message' => "User $user->name created!"]);
    }
    

    public function update($user_id, Request $request) {

        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:20'
        ]);

        try {
            $user = $this->model->find($user_id);

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!', 404]);
            }

            $pass = $request->input('password');

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($pass);
            $user->save();

            return response()->json(['message' => 'Updated successfully!']);
            
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()]);
        }
    }
    

    public function get_posts($user_id) {

        if (!$posts = Post::where('user_id', $user_id)->get()) {

            return response()->json(['message' => "User doesn't exist!"], 404);
        }

        return response()->json([ $posts]);
    }

    
    public function get_post($id, $post_id) {

        if (!$post = Post::where('id', $post_id)->where('user_id', $id)->first()) {

            return response()->json(['message' => "Can't find!"], 404);
        }
        
        return response()->json([$post]);
    }
    
    
    public function create_post(Request $request, Post $post){
        
        $this->validate($request, [
            'title' => 'required|max:75',
            'content' => 'required',
            'status' => 'required',
        ]);
        
        if (!$status = Status::where('status_key', $request->input('status'))->first()){
            
            return response()->json(['message'=>'Wrong status chosen!'], 400);
        }
        
        $slug = self::slug($request->input('title'));
        $auth_user = JWTAuth::parseToken()->toUser();

        try {
            $post->title= $request->input('title');
            $post->content = $request->input('content');
            $post->user_id = $auth_user->id;
            $post->status_id = $status->id;
            $post->slug = $slug;
            $post->save();
            
        } catch (\Exception $e){
            
            return response()->json(['message' => 'Invalid data'], 400);
        }
        
        return response()->json(['message'=>'Post created successfully!']);
    }
    
    
    public function update_post($id, $post_id, Request $request){
        
        $this->validate($request, [
            'title' => 'required|max:75',
            'content' => 'required',
            'status' => 'required'
        ]);
        
        if (!$status = Status::where('status_key', $request->input('status'))->first()){
            
            return response()->json(['message'=>'Wrong status chosen!'], 400); 
        }
        
        if (!$post = Post::where('user_id', $id)->where('id', $post_id)->first()){
            
            return response()->json(['message' => "Can't find post"], 404);
        }
        
        try {
            $post->title= $request->input('title');
            $post->content = $request->input('content');
            $post->status_id = $status->id;
            $post->save();
            
        } catch (Exception $e){
            
            return response()->json(['message' => 'Invalid data'], 400);
        }
        
        return response()->json(['message'=>'Post updated successfully!']);
    }
    
    
    public function delete_post($id, $post_id, Post $post){
        
        $this->model = $post;
        
        if (!$post_find = $post->where('user_id', $id)->where('id', $post_id)->first()){
            
            return response()->json(['message' => "Can't find!"], 404);
            
        }
        
        return $this->delete($post_find->id);
    }
    
    
    public function get_visits($id, $function ='visitors'){
        
        $this->get_post_subresources($id, $function);
    }
    
    public function get_comments($id, $function ='comments'){
        
        $this->get_post_subresources($id, $function);
    }
    
    public function get_roles($id, $function ='roles'){
        
        $this->get_post_subresources($id, $function);
    }
    
    public function add_role_to_user($id, Request $request, Role $role, $function = 'attach'){
        
        return $this->role_control($id, $request, $role, $function);
    }
    
    public function remove_role_to_user($id, Request $request, Role $role, $function = 'detach'){
        
        return $this->role_control($id, $request, $role, $function);
    }
        
    
    public function get_draft_posts($user_id, $function='draft'){
        
        return $this->get_status_posts($user_id, $function);
    }
    
     public function get_unpublished_posts($user_id, $function='unpublished'){
        
        return $this->get_status_posts($user_id, $function);
    }
    
     public function get_published_posts($user_id, $function='published'){
        
        return $this->get_status_posts($user_id, $function);
    }
        
    
    public function publishers(Post $post){
        
        $status = Status::where('status_key', 'published')->first();
        
     $models=$post->where('status_id', $status->id)->with('users')->get();
     
     $data=[];
     
     foreach ($models as $model){
      
         $data[$model->title]=[$model->users];
     }
   
        return response()->json($data); 
    }
    
    public function get_subscribes($id){
        
        if (!$model = $this->model->find($id)){
            
             return response()->json(['message' => "Something went wrong. Please try again!"], 404);  
        }
        
       $subscribes = $model->subscribes()->with('users')->get()->pluck('users');

        return response()->json(['data' => $subscribes]); 
    }
    
    public function create_subscribe_to_user($user_id, $id, Request $request, Subscribe $subscribe, $function = 'App\User'){
        
       return $this->create_subscribe($user_id, $id, $request, $subscribe, $function);
    }
    
     public function create_subscribe_to_post($user_id, $id, Request $request, Subscribe $subscribe, $function = 'App\Post'){
        
       return $this->create_subscribe($user_id, $id, $request, $subscribe, $function);
    }

    public function published_post($id, $post_id, Post $post){
        
        if (!$status = Status::where('status_key', 'published')->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        if (!$model = $post->where('id', $post_id)->where('user_id', $id)->where('status_id', $status->id)->first()){
            
            return response()->json(['message' => "Something went wrong. Please try again!"], 404); 
        }
        
        $auth_user = JWTAuth::parseToken()->toUser();
       
        try {
            $model->visitors()->create([
                'user_id' => $auth_user->id,
                'ip_adress' => $_SERVER["REMOTE_ADDR"],
                'post_id' => $post_id
                    ]);
            
        } catch (\Exception $e) {
      
            return response()->json([$model]);
        }
        
        return response()->json([$model]);
       
        
    }
    
    

}

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BasicController;
use \App\User;
use \App\Role;
use \App\Post;
use \App\Status;
use \App\Visitor;
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
        
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
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
            $user = User::find($user_id);

            if (!$user) {
                return response()->json(['message' => 'User with this ID does not exist!']);
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

            return response()->json(['message' => "User doesn't exist!"]);
        }

        return response()->json(['Data' => $posts]);
    }

    
    public function get_post($id, $post_id) {

        if (!$post = Post::where('id', $post_id)->where('user_id', $id)->first()) {

            return response()->json(['message' => "Can't find!"]);
        }
        
        $auth_user = JWTAuth::parseToken()->toUser();

        try {
            $post->visitors()->create([
                'user_id' => $auth_user->id,
                'ip_adress' => $_SERVER["REMOTE_ADDR"]]);
            
        } catch (\Exception $e) {

            return response()->json(['Data' => $post]);
        }

        return response()->json(['Data' => $post]);
    }
    
    
    public function create_post(Request $request, Post $post){
        
        $this->validate($request, [
            'title' => 'required|max:75',
            'content' => 'required',
            'status' => 'required',
        ]);
        
        if (!$status = Status::where('status_key', $request->input('status'))->first()){
            
            return response()->json(['message'=>'Wrong status chosen!']);
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
            
            return response()->json(['message' => 'Invalid data']);
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
            
            return response()->json(['message'=>'Wrong status chosen!']);
            
        }
        
        if (!$post = Post::where('user_id', $id)->where('id', $post_id)->first()){
            
            return response()->json(['message' => "Can't find post"]);
        }
        
        try {
            $post->title= $request->input('title');
            $post->content = $request->input('content');
            $post->status_id = $status->id;
            $post->save();
            
        } catch (Exception $e){
            
            return response()->json(['message' => 'Invalid data']);
            
        }
        
        return response()->json(['message'=>'Post updated successfully!']);

    }
    
    
    public function delete_post($id, $post_id, Post $post){
        
        $this->model = $post;
        
        if (!$post_find = Post::where('user_id', $id)->where('id', $post_id)->first()){
            
            return response()->json(['message' => "Can't find!"]);
            
        }
        
        return $this->delete($post_find->id);
    }
    
    
    public function get_visits($id){
        
        if (!User::find($id)){
            
            return response()->json(['message' => "Can't find!"]);
            
        }
        
        $user_visits = Visitor::where('user_id', $id)->with('posts')->get();

        return response()->json(['data' => $user_visits]);
    }
    
    
    public function get_comments($id){
        
        if(!$user=User::find($id)){
            
             return response()->json(['message' => "Can't find!"]);  
        }
        
        $data = $user->comments()->get();

        return response()->json(['data' => $data]);
  
    }
    
    public function get_roles($id){
        
        if (!$user = User::find($id)){
            
            return response()->json(['message' => "Can't find!"]);  
            
        }
        
       $data= $user->roles()->get();
        
        return response()->json(['data' => $data]);  
    }

}

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\BasicController;
use \App\User;
use \App\Role;
use \App\Post;
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

    public function create(Request $request, User $user) {


        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|max:20',
                //u input treba staviti "password_confirmation" inputi u njemu ponoviti lozinku
        ]);

        $pass = $request->input('password');

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = app('hash')->make($pass);
        $user->save();


        $roles = Role::where('role_key', env('DEFAULT_USER_ROLE'))->first();

        $user->roles()->attach($roles->id);

        return response()->json(['message' => "Wellcome $user->name!"]);
    }

    public function update($id, Request $request) {

        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:20'
        ]);

        try {
            $user = User::find($id);

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

    public function get_posts($id) {


        if (!$posts = Post::where('user_id', $id)->get()) {

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

}

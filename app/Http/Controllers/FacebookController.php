<?php

namespace App\Http\Controllers;

//Login to FB API using manual login step-to-step using guzzle package


use GuzzleHttp\Client;
use App\User;
use App\Role;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as ExpiredExc;
use Tymon\JWTAuth\Exceptions\TokenInvalidException as InvalidExc;
use Tymon\JWTAuth\Exceptions\JWTException as JWTExc;



class FacebookController extends Controller {
    
    protected $client_id = '1793986114235256';
    protected $redirect = 'http://fblogin.dev/callback';
    protected $secret = '87f84a794c2cfcb6ecf3d8247d4de992';
    protected $ver = 'v2.11';
    
    
    public function login(){
        
        
        return redirect("https://www.facebook.com/$this->ver/dialog/oauth?client_id=$this->client_id&redirect_uri=$this->redirect");
     
    }
    
    public function callback(Request $request, User $social_user){
        
   
        if (isset($_GET['code'])){
         
            $code = $_GET['code'];
            $client = new Client(['base_uri' => 'https://graph.facebook.com']);
            $response = $client->request('GET', "/$this->ver/oauth/access_token?client_id=$this->client_id&redirect_uri=$this->redirect&client_secret=$this->secret&code=$code");
            $access_token = json_decode($response->getBody())->access_token;
          
        }
        
            $response_to_data = $client->request('GET', "/me?fields=id,name,email&access_token=$access_token");
           
                $body= json_decode($response_to_data->getBody());
              
            
        if (!$fb_user = $social_user->where('email', $body->email)->where('fb_id', $body->id)->first()){
                
            try {
                
                $roles = Role::where('role_key', env('DEFAULT_USER_ROLE'))->first();
                
                $fb_user = $social_user->create([
                    'name'=>$body->name,
                        'email' => $body->email,
                            'fb_id' => $body->id
                ]);
                
                $fb_user->roles()->attach($roles->id);
                
           } catch (\Exception $e){
               return $response_to_data->getBody();
           }
        }
        
        $fb_user_roles = $fb_user->roles()->get();
        
        
         $customclaimsarray = [];

            foreach ($fb_user_roles as $role) {

                array_push($customclaimsarray, $role->role_key);
            }

            $token = JWTAuth::fromUser($fb_user, ['roles' => $customclaimsarray]);
       
            return response()->json([$token]);
    }
    
    
}

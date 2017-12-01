<?php

namespace App\Http\Controllers;

//Login to FB API using manual login step-to-step using guzzle package

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;



class FacebookController extends Controller {
    
    
    public function login(){
        
        
        return redirect('https://www.facebook.com/v2.11/dialog/oauth?client_id=1793986114235256&redirect_uri=http://fblogin.dev/callback');
     
    }
    
    public function callback(Request $request, User $social_user){
        
   
        if (isset($_GET['code'])){
         
            
            $code = $_GET['code'];
            
            $client = new Client(['base_uri' => 'https://graph.facebook.com']);
            $response = $client->request('GET', "/v2.11/oauth/access_token?client_id=1793986114235256&redirect_uri=http://fblogin.dev/callback&client_secret=87f84a794c2cfcb6ecf3d8247d4de992&code=$code");
          
            $access_token = json_decode($response->getBody())->access_token;
          

        }
        
            $response_to_data = $client->request('GET', "/me?fields=id,name,email&access_token=$access_token");
           
            $name = json_decode($response_to_data->getBody())->name;
            $email = json_decode($response_to_data->getBody())->email;
            $fb_id = json_decode($response_to_data->getBody())->id;
            
           try {
                
                $social_user->create([
                    'name'=>$name,
                        'email' => $email,
                            'fb_id' => $fb_id
                    
                ]);
                
           } catch (\Exception $e){
               return $response_to_data->getBody();
               
           }
                

            return $response_to_data->getBody();
        

    }
    
    
}

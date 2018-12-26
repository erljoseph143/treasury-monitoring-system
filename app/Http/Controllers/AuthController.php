<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
	    $http = new \GuzzleHttp\Client;
	    try{
		    $response = $http->post(config("services.passport.login_endpoint"), [
			    'form_params' => [
				    'grant_type' => 'password',
				    'client_id' => config('services.passport.client_id'),
				    'client_secret' => config('services.passport.client_secret'),
				    'username' => $request->username,
				    'password' => $request->password
			    ],
		    ]);
		    return json_decode((string) $response->getBody(), true);
	    }
	    catch (\GuzzleHttp\Exception\BadResponseException $e)
	    {
	        if($e->getCode() == 400)
	        {
	            return response()->json("Invalid request please enter your username and password", $e->getCode());
	        }
	        else if($e->getCode() == 401)
	        {
		        return  response()->json("Your credentials is incorrect please try again " . $e->getMessage(), $e->getCode());
	        }
	        return response()->json("Something went wrong on the server " . $e->getMessage(), $e->getCode());
	    }

    }
    
    public function logout()
    {
        Auth()->user()->tokens->each(function($tokens,$key){
        	$tokens->delete();
        });

        return response()->json('Successfully logout',200);
    }
    
    public function getUserData()
    {
	    dd(auth('api')->user());
    }
	
	public function testauth1(Request $request) {
		// return auth()->user(); // does not return user
		dd(Auth::guard('api')->user()); // does not return user
	}
	
	public function testauth2() {
    	//dd(auth('api')->user());
		return auth()->user(); // returns user
	}
}

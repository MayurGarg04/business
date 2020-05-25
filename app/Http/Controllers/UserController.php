<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{	

    private $client;

	public function __construct()
    {
        $this->client = new Client;
    }

    /*
		Request from user to register 
	*/

    public function register(Request $request)
    {
        //dd($request->all());
    	try {

            $response = $this->client->post('http://localhost/senior/api/v1.0/public/register', [
                    'headers' => [
                      'Accept' => 'application/json',
                      'appid' => 'paytm'
                    ],
                    'json' => [
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'dob' => '1945-05-06',
                        'city' => $request->get('city'),
                        'amount' => $request->get('amount'),
                        'phone' => $request->get('phone')
                    ],
              ]);

            return $response->getBody();

    	}  catch (ClientException $e) {

           return $e->getResponse()->getBody();
        }

    }

    /*
		Request from user to login on success store 
	*/

    public function login(Request $request)
    {  
    	try {
            
            $response = $this->client->post('http://localhost/senior/api/v1.0/public/login', [
                  'json' => [
            			'email' => $request->get('email'),
            			'password' => $request->get('password'),
                  ],
              ]);

            //return $response->getBody();
            $responseData = json_decode($response->getBody()->getContents());

            $accessToken = $responseData->token;
            $appId = $responseData->appid;

            if($accessToken) {
                $request->session()->put('access_token', $accessToken);
                $request->session()->put('appid', $appId);

                $users = $this->getUsersByAppId($request); 

                if($users) {
                    return $users;
                } else {
                    return response()->json(['message' => 'No data found!','status' => true, 'code' => 201], 201);
                }
            }    
            
    	}  catch (ClientException $e) {
            return $e->getResponse()->getBody();    		
        }

    }

    /*
        Request from to get users by appid OR users belongs to logedin user.
    */

    public function getUsersByAppId(Request $request)
    {   
        $response = $this->client->get('http://localhost/senior/api/v1.0/public/users', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ]
        ]);

        return $response->getBody()->getContents();
    }

    /*
		Request from to fetch all users
	*/

	public function users(Request $request)
	{
		/*try {
            $response = $this->client->post('http://localhost/senior/api/v1.0/public/register', [
                  'form_params' => [
                        'name' => 'priyaaa ali khan',
            			'email' => 'priyaaa@ww.com',
            			'dob' => '1995-05-06',
            			'city' => 'Noaaida',
            			'amount' => '8411',
            			'appid' => 'paytm',
            			'phone' => '7512598524'
                  ],
              ]);

            $responseData = json_decode($response->getBody()->getContents());
            die("intry");
    	}  catch (ClientException $e) {
            //print_r($e->getResponse()->getBody()->getContents());
            die($e);
            return $e->getResponse()->getBody()->getContents();
        }*/
	}


}

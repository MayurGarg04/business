<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use Session;

class UserController extends Controller
{	

    private $client;

	public function __construct()
    {
        $this->client = new Client;
    }

    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }


    /*
		Request from user to register 
	*/

    public function register(Request $request)
    {
    	try {

            $response = $this->client->post(env('API_URL').'register', [
                    'headers' => [
                      'Accept' => 'application/json',
                      'appid' => 'paytm'
                    ],
                    'json' => [
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        //'dob' => '1945-05-06',
                        'dob' => $request->get('dob'),
                        'city' => $request->get('city'),
                        'amount' => $request->get('amount'),
                        'phone' => $request->get('phone')
                    ],
              ]);

            $responseData = $response->getBody()->getContents();
            return redirect('register')->with('message', 'Registration completed successfully!');
    	}  catch (ClientException $e) {

           $responseBody = $e->getResponse()->getBody()->getContents();
            return redirect()->back()->withErrors(json_decode($responseBody));
        }

    }

    /*
		Request from user to login on success store 
	*/

    public function login(Request $request)
    {  
    	try {
            
            $response = $this->client->post(env('API_URL').'login', [
                  'json' => [
            			'email' => $request->get('email'),
            			'password' => $request->get('password'),
                  ],
              ]);

            $responseData = json_decode($response->getBody()->getContents());

            $accessToken = $responseData->token;
            $appId = $responseData->app_id;

            if($accessToken) {
                $request->session()->put('access_token', $accessToken);
                $request->session()->put('appid', $appId);

                return redirect('users')->with('message', 'Login successfully!');
               
            }    
            
    	}  catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
           // dd(json_decode($responseBody));
            return redirect()->back()->withErrors(json_decode($responseBody));
        }

    }

    /*
        Request from to get users by appid OR users belongs to logedin user.
    */

    public function getUsersByAppId(Request $request)
    {   
        $response = $this->client->get(env('API_URL').'users', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ]
        ]);
        $userlist = $response->getBody()->getContents();
        return $userlist;
    }

    public function getUsers(Request $request)
    {
        try {
            $response = $this->client->post(env('API_URL').'users', [
                  'form_params' => [
                        'name' => 'mayur',
                        'email' => 'hello@ww.com',
                        'dob' => '1995-05-06',
                        'city' => 'noida',
                        'amount' => '8411',
                        'appid' => 'paytm',
                        'phone' => '7512598524'
                  ],
              ]);

            $responseData = json_decode($response->getBody()->getContents());
        }  catch (ClientException $e) {
            //print_r($e->getResponse()->getBody()->getContents());

            return $e->getResponse()->getBody()->getContents();
        }
    }

    public function editUser(Request $request) {
        //dd($request->all());
        $response = $this->client->get(env('API_URL').'users/'.$request->get('id'), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ],
            'params' => [
                'id' => $request->get('id'),
            ]
        ]);
        $user = $response->getBody()->getContents();
        return $user;
    }    

    public function updateUser(Request $request)
    {   
        $response = $this->client->post(env('API_URL').'users', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ],
            'form_params' => [
                'id' => $request->get('id'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'dob' => '1945-05-06',
                'city' => $request->get('city'),
                'amount' => $request->get('amount'),
                'phone' => $request->get('phone')
            ]
        ]);
        $user = $response->getBody()->getContents();
        return $user;
    }

    public function updateStatus(Request $request)
    {   
        $response = $this->client->post(env('API_URL').'updatedonor', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ],
            'form_params' => [
                'ids' => $request->get('id'),
            ]
        ]);
        $user = $response->getBody()->getContents();
        return $user;
    }
    public function deleteUser(Request $request)
    {
         $response = $this->client->post(env('API_URL').'deleteuser', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$request->session()->get('access_token'),
                'appid' => $request->session()->get('appid')
            ],
            'form_params' => [
                'id' => $request->get('id'),
            ]
        ]);
        $user = $response->getBody()->getContents();
        return $user;
    }
    
    public function logout() {
        Session::flush();

        return redirect()->route('login');
    }


}

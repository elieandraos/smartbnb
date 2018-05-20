<?php

namespace App\Http\Controllers\Api;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Smartbnb\ApiResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
	protected $apiResponse;

	public function __construct(ApiResponse $apiResponse)
	{
		$this->apiResponse = $apiResponse;
	}

	/**
	 * Register the user
	 * 
	 * @return type
	 */
    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
        	'name' 		 => 'required', 
        	'email' 	 => 'required|email|unique:users,email', 
        	'password' 	 => 'required', 
            'country_id' => 'required|exists:countries,id'
        ]);

    	// return validation errors if any
    	if ($validator->fails())
    		return $this->apiResponse->respondBadRequest($data = [], $validator->errors());

    	// persist the user in the database
    	$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $input['bonus_percent'] = random_int(5,20);
        $user = User::create($input); 
        $personalToken = $user->createToken('smartbnb')->accessToken; 

        // return his personal access token to be consumed by other apis
        return $this->apiResponse->respondOk(['token' => $personalToken]);
    }

    /**
     * Login the user.
     * 
     * @param Request $request 
     * @return type
     */
    public function login(Request $request)
    {
    	if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){ 
            $user = Auth::user(); 
            $personalToken = $user->createToken('smartbnb')->accessToken; 
            return $this->apiResponse->respondOk(['token' => $personalToken]);
        } 
        else{ 
            return $this->apiResponse->respondUnauthorized($data = [], ['Invalid login credentials']);
        } 
    }
}

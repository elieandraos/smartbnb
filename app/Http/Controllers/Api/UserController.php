<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Smartbnb\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
	public function __construct(ApiResponse $apiResponse)
	{
		$this->apiResponse = $apiResponse;
	}

	/**
	 * Return the user details
	 * 
	 * @param Request $request 
	 * @return type
	 */
	public function index(Request $request)
	{
		$user = $request->user();
		return $this->apiResponse->respondOk(new UserResource($user)); 
	}

	/**
	 * Update the user info.
	 * 
	 * @param Request $request 
	 * @return type
	 */
    public function update(Request $request)
    {
    	$user = $request->user();
    	
    	$validator = Validator::make($request->all(), [ 
        	'name' 		 => 'required', 
        	'email' 	 => 'required|email|unique:users,email,'.$user->id, 
        	'password' 	 => 'required', 
            'country_id' => 'required|exists:countries,id'
        ]);

        // return validation errors if any
    	if ($validator->fails())
    		return $this->apiResponse->respondBadRequest($data = [], $validator->errors());

    	$input = $request->all();
    	$input['password'] = bcrypt($input['password']); 
    	$user->update($input);
    	return $this->apiResponse->respondOk(['user updated successfully.']); 
    }
}

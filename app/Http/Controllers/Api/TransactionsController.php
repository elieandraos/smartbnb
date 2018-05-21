<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Smartbnb\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionsController extends Controller
{
    public function __construct(ApiResponse $apiResponse)
	{
		$this->apiResponse = $apiResponse;
	}

	/**
	 * Display list of transations history
	 * 
	 * @param Request $request 
	 * @return type
	 */
	public function index(Request $request)
	{
		$user = $request->user();

		$validator = Validator::make($request->all(), [ 
        	'start_date' 	 => 'date_format:Y-m-d|required_with:end_date', 
        	'end_date' 	 	 => 'date_format:Y-m-d|after_or_equal:start_date', 
        ]);

        // return validation errors if any
    	if ($validator->fails())
    		return $this->apiResponse->respondBadRequest($data = [], $validator->errors());

		$transactions = Transaction::where('user_id', $user->id)
							->afterDate($request->get('start_date'))
							->beforeDate($request->get('end_date'))
							->orderBy('created_at', 'DESC')
							->get();

		return $this->apiResponse->respondOk(TransactionResource::collection($transactions));
	}

	/**
	 * Display a single transaction
	 * 
	 * @param Request $request 
	 * @param type $transationId 
	 * @return type
	 */
	public function show(Request $request, $transactionId)
	{
		$user = $request->user();
		$transaction = Transaction::where('id', $transactionId)->where('user_id', $user->id)->firstOrFail();
		return $this->apiResponse->respondOk(new TransactionResource($transaction)); 
	}
}

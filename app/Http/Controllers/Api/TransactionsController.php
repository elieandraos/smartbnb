<?php

namespace App\Http\Controllers\Api;

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

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Smartbnb\ApiResponse;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    public function __construct(ApiResponse $apiResponse)
	{
		$this->apiResponse = $apiResponse;
	}
}

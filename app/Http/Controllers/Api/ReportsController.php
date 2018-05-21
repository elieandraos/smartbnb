<?php

namespace App\Http\Controllers\Api;

use DB;
use Validator;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Smartbnb\ApiResponse;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
	 public function __construct(ApiResponse $apiResponse)
	{
		$this->apiResponse = $apiResponse;
	}

	/**
	 * Dashboard report that displays summary of all the transactions.
	 * 
	 * 
	 * @param Request $request 
	 * @return type
	 */
    public function dashboard(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
        	'start_date' 	 => 'date_format:Y-m-d|required_with:end_date', 
        	'end_date' 	 	 => 'date_format:Y-m-d|after_or_equal:start_date', 
        ]);

        // return validation errors if any
    	if ($validator->fails())
    		return $this->apiResponse->respondBadRequest($data = [], $validator->errors());


    	// run one query and get the results by filtering the collection
    	$transactions = Transaction::with('user')
    								->afterDate($request->get('start_date'))
									->beforeDate($request->get('end_date'))
									->get();

    	return $this->apiResponse->respondOk([
    		'nb_transations'  	=> $transactions->count(),
 			'nb_deposits'		=>	$transactions->where('deposit', true)->count(),
 			'nb_withdrawals'	=>	$transactions->where('deposit', false)->count(),
    		'total_deposit'	  	=> $transactions->where('deposit', true)->sum('amount'),
    		'total_withdraw'  	=> $transactions->where('deposit', false)->sum('amount'),
    		'nb_users' 		  	=> $transactions->groupBy('user_id')->count(),
    		'total_countries' 	=> $transactions->groupBy('user.country_id')->count()
    	]);
    }

    /**
     * Aggregated reports by days and countries
     * 
     * @param Request $request 
     * @return type
     */
    public function aggregated(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
        	'start_date' 	 => 'date_format:Y-m-d|required_with:end_date', 
        	'end_date' 	 	 => 'date_format:Y-m-d|after_or_equal:start_date', 
        ]);

        // return validation errors if any
    	if ($validator->fails())
    		return $this->apiResponse->respondBadRequest($data = [], $validator->errors());

    	// run one query and get the results by manipulating the results collection
    	$transactions = Transaction::with('user')
    								->addSelect('*', DB::raw('DATE(created_at) as day'))
    								->afterDate($request->get('start_date'))
									->beforeDate($request->get('end_date'))
    								->orderBy('day', 'DESC')
    								->get();
    	
    	$results = $transactions
    				->groupBy('day')
    				->map(function($items){
						return $items->groupBy('user.country_name')
									->map(function($rows){
										return [
											'nb_transations'  	=>  $rows->count(),
								 			'nb_deposits'		=>	$rows->where('deposit', true)->count(),
								 			'nb_withdrawals'	=>	$rows->where('deposit', false)->count(),
								    		'total_deposit'	  	=>  $rows->where('deposit', true)->sum('amount'),
								    		'total_withdraw'  	=>  $rows->where('deposit', false)->sum('amount'),
								    		'nb_users' 		  	=>  $rows->groupBy('user_id')->count(),
										];
									});
					});

		return $this->apiResponse->respondOk($results);
    }
}

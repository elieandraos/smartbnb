<?php 

namespace App\Smartbnb;

use Auth;
use Illuminate\Validation\Validator;

/**
 * Custom validator that checks if the user have enough to withdraw the requested amount
 */
class AmountLimitValidator extends Validator {

    public function validateAmountLimit($attribute, $value, $parameters)
    {
    	$amount = Auth::user()->amount;
        return $value <= $amount;
    }
}


?>
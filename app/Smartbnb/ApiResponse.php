<?php 

namespace App\Smartbnb;

/**
 * A class that format all api responses in a standard way and more verbose functions naming.
 */
class ApiResponse
{
	protected $status_code = 200;

	/**
	 * Get the status code
	 * 
	 * @return type
	 */
	public function getStatusCode()
	{
		return $this->status_code;
	}

	/**
	 * Set the status code
	 * 
	 * @param type $status_code 
	 * @return type
	 */
	public function setStatusCode($status_code = 200)
	{
		$this->status_code = $status_code;
		return $this;
	}

	/**
	 * Respond method
	 * 
	 * @param type|array $data 
	 * @param type|array $errors 
	 * @param type|null $message 
	 * @return type
	 */
	public function respond($data = [], $errors = [], $message = null)
	{	
		return response()->json([
    			'message' =>  $message,
    			'data'	  =>  $data,
    			'errors'  =>  $errors,
    			'code'	  =>  $this->getStatusCode()
    		], 
    		$this->getStatusCode());        
	}
	
	/**
	 * 200 successfull request
	 * 
	 * @param type $message 
	 * @return type
	 */
	public function respondOk($data = [], $errors = [], $message = "The request has succeeded")
	{
		return $this->setStatusCode(200)->respond($data, $errors, $message);
	}

	/**
	 * 400 Bad Request
	 * 
	 * @param type|string $message 
	 * @return type
	 */
	public function respondBadRequest($data = [], $errors = [], $message = "Error bad request")
	{
		return $this->setStatusCode(400)->respond($data, $errors, $message);
	}

	/**
	 * 401 Unauthorized
	 * 
	 * @param type|string $message 
	 * @return type
	 */
	public function respondUnauthorized($data = [], $errors = [], $message = "Request unauthorized")
	{
		return $this->setStatusCode(401)->respond($data, $errors, $message);
	}

	/**
	 * 404 Unauthorized
	 * 
	 * @param type|string $message 
	 * @return type
	 */
	public function respondNotFound($data = [], $errors = [], $message = "Request not found")
	{
		return $this->setStatusCode(404)->respond($data, $errors, $message);
	}

	/**
	 * 405 Method not allowed
	 * 
	 * @param type|string $message 
	 * @return type
	 */
	public function respondNotAllowed($data = [], $errors = [], $message = "Request method not allowed")
	{
		return $this->setStatusCode(405)->respond($data, $errors, $message);
	}

}

?>
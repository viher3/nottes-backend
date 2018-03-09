<?php
	
	namespace App\Tests;

	class AuthenticationHelper
	{
	    public function getAuthToken()
	    {
	    	$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:8000/api/login_check");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "_username=phpunit&_password=1234");


			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			curl_close($ch);

			$result = json_decode($server_output, true);

			return ( ! empty($result['token'])) ? "Bearer " . $result['token'] : "";
	    }
	}
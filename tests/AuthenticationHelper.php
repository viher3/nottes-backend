<?php
	
	namespace App\Tests;

	class AuthenticationHelper
	{
	    public function getAuthToken($client, $username="phpunit", $password=1234)
	    {
	    	$client->request(
		        'POST',
		        '/api/login_check',
		        array(
		            '_username' => $username,
		            '_password' => $password,
		        )
		    );

		    $data = json_decode($client->getResponse()->getContent(), true);

		    // add jwt to th eauth header
		    $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

		    return $client;
	    }
	}
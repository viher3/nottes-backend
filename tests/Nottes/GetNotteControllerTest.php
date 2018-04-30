<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class GetNotteControllerTest extends WebTestCase
	{
	    public function testAdd()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/notte/2"
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }

	    public function testUnauthorizedDoc()
	    {
	    	$client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/notte/3"
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(401, $client->getResponse()->getStatusCode());
		    $this->assertEquals($result, "HTTP_UNAUTHORIZED");	
	    }
	}
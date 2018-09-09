<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class GetNotteControllerTest extends WebTestCase
	{
	    public function testGet()
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

	    public function testGetHtml()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/notte/2",
		      [
		      	"format" => "html"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }

	    public function testGetEncryptedDoc()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/notte/4",
		      [
		      	"pwd" => "123456"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['content']);
		    $this->assertEquals($result['content'], "encrypted");
	    }

	    public function testGetError()
	    {
	    	$client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/notte/4",
		      [
		      	"pwd" => "wrong_pwd"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(500, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['error']);
		    $this->assertEquals($result['error'], "wrong_encryption_password");
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
<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class CreateLinkController extends WebTestCase
	{
	    public function testAdd()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/link",
		      [
		        "name" => "Test link",
		        "content" => "https://www.albertolabs.com",
		        "tags" => "link,test"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
		    $this->assertEquals($result['type'], "link");
	    }

		public function testInvalidForm()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/link",
		      [
		        "randomField" => "test"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(500, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['form']['children']);
	    }

	    public function testErrorSavingEntity()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/notte",
		      [
		        "name" => new \stdClass(),
		        "content" => "phpunit-test",
		        "tags" => "phpunit,test"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(500, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['ERROR']);
		    $this->assertEquals($result['ERROR'], "SAVING_DATA");
	    }
	}
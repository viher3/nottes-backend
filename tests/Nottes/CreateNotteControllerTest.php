<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class CreateNotteControllerTest extends WebTestCase
	{
	    public function testAdd()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/notte",
		      [
		        "name" => "test",
		        "content" => "phpunit-test",
		        "tags" => "phpunit,test",
		        "isEncrypted" => false
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }

	    public function testInvalidForm()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/notte",
		      [
		        "name" => "test"
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
		        "tags" => "phpunit,test",
		        "isEncrypted" => false
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(500, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['ERROR']);
		    $this->assertEquals($result['ERROR'], "SAVING_DATA");
	    }

	    public function testEncrytion()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/notte",
		      [
		        "name" => "test",
		        "content" => "phpunit-test",
		        "tags" => "phpunit,test",
		        "isEncrypted" => true,
		        "encryptionpwd2" => "1234"
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }
	}
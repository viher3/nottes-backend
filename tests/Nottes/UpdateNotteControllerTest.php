<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class UpdateNotteControllerTest extends WebTestCase
	{
	    public function testUpdate()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "PUT",
		      "/api/notte/1",
		      [
		        "name" => "test updated",
		        "content" => "phpunit-test updated",
		        "tags" => "phpunit,test, updated",
		        "isEncrypted" => false
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }

	    // TODO: update an encrypted document
	    // TODO: update an encrypted doc and save it as non-encrypted document
	}
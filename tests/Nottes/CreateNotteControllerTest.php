<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class CreateNotteControllerTest extends WebTestCase
	{
	    public function testAdd()
	    {
	        $authToken 	= ( new AuthenticationHelper() ) ->getAuthToken();
	        $client 	= static::createClient();

	        $client->request(
		      "POST",
		      "/api/notte",
		      [
		        "name" => "test",
		        "content" => "phpunit-test",
		        "tags" => "phpunit,test",
		        "isEncrypted" => false
		      ],
		      [],
		      [
		        'HTTP_AUTHORIZATION' => $authToken
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result['id']);
	    }
	}
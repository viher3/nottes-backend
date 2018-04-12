<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class DeleteNotteControllerTest extends WebTestCase
	{
	    public function testDelete()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "DELETE",
		      "/api/notte/1"
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	    }
	}
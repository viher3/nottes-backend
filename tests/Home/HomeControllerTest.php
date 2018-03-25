<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class HomeControllerTest extends WebTestCase
	{
	    public function testAdd()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/"
		    );

		    $result = $client->getResponse()->getContent();

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertContains("Nottes api!", $result);
	    }
	}
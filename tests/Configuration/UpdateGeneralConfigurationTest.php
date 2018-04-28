<?php
	
	namespace App\Tests\Configuration;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class UpdateGeneralConfigurationTest extends WebTestCase
	{
	    public function testIndex()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "PUT",
		      "/api/configuration/general"
		    );

		    $result = $client->getResponse()->getContent();

		    var_dump($result);
		    die('---');

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    // $this->assertContains("Nottes api!", $result);
	    }
	}
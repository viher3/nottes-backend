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
		      "/api/configuration/general",
		      [
		      	"nickname" => "test nickname",
		      	"email" => "phpunit@general-configuration.com",
		      	"language" => "es",
		      	"password" => 1234
		      ]
		    );

		    $result = $client->getResponse()->getContent();
		    $result = json_decode($result, true);

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result["id"]);
	    }
	}
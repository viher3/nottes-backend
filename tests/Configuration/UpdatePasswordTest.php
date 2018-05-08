<?php

namespace App\Tests\Configuration;

use App\Entity\Notte;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\AuthenticationHelper;

class UpdatePasswordTest extends WebTestCase
{
	public function testIndex()
    {
        $client	= static::createClient();
        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

        $client->request(
	      "PUT",
	      "/api/configuration/security/password",
	      [
	      	"currentPassword" => 1234,
	      	"newPassword" => 1234
	      ]
	    );

	    $result = $client->getResponse()->getContent();
	    $result = json_decode($result, true);

	    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	    $this->assertNotEmpty($result["id"]);
    }

	public function testWrongCurrentPassword()
    {
        $client	= static::createClient();
        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

        $client->request(
	      "PUT",
	      "/api/configuration/security/password",
	      [
	      	"currentPassword" => 1234321,
	      	"newPassword" => 1234
	      ]
	    );

	    $result = $client->getResponse()->getContent();
	    $result = json_decode($result, true);

	    $this->assertEquals(500, $client->getResponse()->getStatusCode());
	    $this->assertNotEmpty($result["error"]);
	    $this->assertEquals($result["error"], "invalid_password");
    }

	public function testInvalidForm()
    {
        $client	= static::createClient();
        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

        $client->request(
	      "PUT",
	      "/api/configuration/security/password",
	      [
	      	"asdfsd" => 1234321,
	      	"newPassword" => 1234
	      ]
	    );

	    $result = $client->getResponse()->getContent();
	    $result = json_decode($result, true);

	    $this->assertEquals(422, $client->getResponse()->getStatusCode());
	    $this->assertNotEmpty($result["form"]["errors"]);
	    $this->assertEquals($result["form"]["errors"][0], "This form should not contain extra fields.");
    }

    public function testUpdateUserException()
    {
    	$client	= static::createClient();
        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

        $client->request(
	      "PUT",
	      "/api/configuration/security/password",
	      [
	      	"currentPassword" => 1234,
	      	"newPassword" => new \stdClass()
	      ]
	    );

	    $result = $client->getResponse()->getContent();
	    $result = json_decode($result, true);

	    $this->assertEquals(500, $client->getResponse()->getStatusCode());
	    $this->assertNotEmpty($result["error"]);
    }
}
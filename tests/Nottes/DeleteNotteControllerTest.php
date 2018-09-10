<?php
	
	namespace App\Tests\Nottes;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class DeleteNotteControllerTest extends WebTestCase
	{
		private $notteId;

		public function setUp()
	    {
	    	$kernel = self::bootKernel();
	    	$this->em = $kernel->getContainer()->get('doctrine')->getManager();

	    	// get test document id
	    	$notte = $this->em->getRepository(Notte::class)->findOneBy(['name' => 'notte-to-delete']);
	    	$this->notteId = $notte->getId();
	    }

	    public function testDelete()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "DELETE",
		      "/api/notte/" . $this->notteId
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	    }
	}
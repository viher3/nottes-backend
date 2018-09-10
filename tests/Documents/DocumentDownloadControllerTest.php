<?php
	
	namespace App\Tests\Documents;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;

	class DocumentDownloadControllerTest extends WebTestCase
	{
		private $em;
		private $documentId;

		public function setUp()
	    {
	    	$kernel = self::bootKernel();
	    	$this->em = $kernel->getContainer()->get('doctrine')->getManager();

	    	// get test document id
	    	$notte = $this->em->getRepository(Notte::class)->findOneBy(['name' => 'test_doc']);
	    	$this->documentId = $notte->getDocument()->getId();
	    }

	    public function testIndex()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "GET",
		      "/api/document/" . $this->documentId
		    );

		    $result = $client->getResponse();
			
		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result->getFile());
	    }
	}
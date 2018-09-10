<?php
	
	namespace App\Tests\Documents;

	use App\Entity\Notte;
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	use App\Tests\AuthenticationHelper;
	use Symfony\Component\HttpFoundation\File\UploadedFile;

	class DocumentUploadControllerTest extends WebTestCase
	{
		private $uploadDir;

		public function setUp()
	    {
	    	$kernel = self::bootKernel();

	    	// get upload path
			$currDir = __DIR__;
			$uploadDirArray = explode("tests", $currDir);
			$this->uploadDir = $uploadDirArray[0] . "public/uploads/";

			// create temp files
	        $file = tempnam(sys_get_temp_dir(), 'upl');
	        $file2 = tempnam(sys_get_temp_dir(), 'upl');

	        // create and write image/png to it
	        \imagepng(\imagecreatetruecolor(10, 10), $file); 
	        \imagepng(\imagecreatetruecolor(10, 10), $file2);

	        $this->files = [
	        	new UploadedFile($file, 'new_image.png', null, null, true),
	        	new UploadedFile($file2, 'new_image_2.png', null, null, true)
	        ];
	    }

	    public function testIndex()
	    {
	        $client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/document",
		      [],
		      [
		        "files" => $this->files
		      ]
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(200, $client->getResponse()->getStatusCode());
		    $this->assertNotEmpty($result[0]['filepath']);
		    $this->assertNotEmpty($result[1]['filepath']);
	    }

	    public function testEmptyFilesParam()
	    {
	    	$client	= static::createClient();
	        $client	= ( new AuthenticationHelper() )->getAuthToken($client);

	        $client->request(
		      "POST",
		      "/api/document",
		      []
		    );

		    $result = json_decode( $client->getResponse()->getContent(), true );

		    $this->assertEquals(422, $client->getResponse()->getStatusCode());
	    }
	}
<?php

	namespace App\Tests\Services\Upload;

	use PHPUnit\Framework\TestCase;
	use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

	use App\Entity\User;
	use App\Services\Upload\FileUpload;
	use Symfony\Component\HttpFoundation\File\UploadedFile;

	class FileUploadTest extends KernelTestCase
	{
		protected $files;
		protected $uploadDir;
		protected $em;
		protected $user;

		public function setUp()
	    {
	    	$kernel = self::bootKernel();

	        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
	        $this->user = $this->em->getRepository(User::class)->findOneBy(array('username' => 'phpunit'));

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

		public function testUploadFiles()
		{
			// instance FileUpload class
			$fileUpload = new FileUpload(
								$this->files, 
								$this->em, 
								$this->uploadDir,
								$this->user
							);

			$result = $fileUpload->uploadFiles();

			$this->assertNotEmpty($result[0]['filepath']);
			$this->assertNotEmpty($result[0]['filepath']);
			
			$this->assertNotEmpty($result[1]['filepath']);
			$this->assertNotEmpty($result[1]['fileInfo']);
		}
	}
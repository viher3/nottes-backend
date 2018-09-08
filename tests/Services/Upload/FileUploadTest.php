<?php

	namespace App\Tests\Services\Upload;

	use PHPUnit\Framework\TestCase;
	use App\Services\Upload\FileUpload;
	use Symfony\Component\HttpFoundation\File\UploadedFile;

	class FileUploadTest extends TestCase
	{
		protected $files;

		protected $uploadDir;

		public function setUp()
	    {
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
								$this->uploadDir
							);

			$result = $fileUpload->uploadFiles();

			$this->assertNotEmpty($result[0]['filepath']);
			$this->assertNotEmpty($result[0]['filepath']);
			
			$this->assertNotEmpty($result[1]['filepath']);
			$this->assertNotEmpty($result[1]['fileInfo']);
		}
	}
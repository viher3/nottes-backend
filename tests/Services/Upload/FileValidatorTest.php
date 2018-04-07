<?php

	namespace App\Tests\Services\Upload;

	use PHPUnit\Framework\TestCase;
	use App\Services\Upload\FileValidator;
	use Symfony\Component\HttpFoundation\File\UploadedFile;

	class FileValidatorTest extends TestCase
	{
		protected $file;
		protected $image;

		public function setUp()
	    {
	        $this->file = tempnam(sys_get_temp_dir(), 'upl'); // create file

	        \imagepng(\imagecreatetruecolor(10, 10), $this->file); // create and write image/png to it

	        $this->image = new UploadedFile(
	            $this->file,
	            'new_image.png'
	        );
	    }

		public function testValidateImage()
		{
			$fileValidator = new FileValidator();
			$result = $fileValidator->validateImage($this->image);

			$this->assertTrue($result);
		}
	}
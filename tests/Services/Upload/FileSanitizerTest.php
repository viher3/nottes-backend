<?php

	namespace App\Tests\Services\Upload;

	use PHPUnit\Framework\TestCase;
	use App\Services\Upload\FileSanitizer;

	class FileSanitizerTest extends TestCase
	{
		public function testSanitize()
		{
			$fileSanitizer = new FileSanitizer();
			$result = $fileSanitizer->sanitize("?¿ñññ$");

			$this->assertStringEndsWith("n", $result);
		}
	}
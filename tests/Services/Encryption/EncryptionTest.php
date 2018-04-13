<?php

	namespace App\Tests\Services\Encryption;

	use PHPUnit\Framework\TestCase;
	use Defuse\Crypto\Crypto;

	class EncryptionTest extends TestCase
	{
		private $testContent 	= "test content to encrypt";
		private $testPassword 	= "testPassword";

		public function testEncrypt()
		{
			$result = Crypto::encryptWithPassword($this->testContent, $this->testPassword);

			$this->assertNotEquals($result, $this->testContent);
		}

		public function testDecrypt()
		{
			$encrypted 		 = Crypto::encryptWithPassword($this->testContent, $this->testPassword);
			$decryptedResult = Crypto::decryptWithPassword($encrypted, $this->testPassword);

			$this->assertEquals($this->testContent, $decryptedResult);
		}

	}
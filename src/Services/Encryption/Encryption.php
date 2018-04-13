<?php

	namespace App\Services\Encryption;

	use Defuse\Crypto\Crypto;

	class Encryption
	{
		public function encrypt($content, $password)
		{
			return Crypto::encryptWithPassword($content, $password);
		}

		public function decrypt($content, $password)
		{
			return Crypto::decryptWithPassword($content, $password);
		}
	}
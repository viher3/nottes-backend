<?php

	namespace App\Services\Upload;

	class FileValidator
	{
		private $error;
		//private $maxImageSizeInMb = 50;
		private $maxImageSizeInMb = 0.2;
		private $maxImageSizeInBytes;
		private $allowedMimeTypes = [
			"image/png",
			"image/jpeg",
			"image/gif"
		];

		public function __construct()
		{
			$this->maxImageSizeInBytes = 1024 * ($this->maxImageSizeInMb * 1024);
		}

		public function validateImage($file)
		{
			$fileMimeType 	= $file->getMimeType();
			$fileSize 		= $file->getClientSize();

			if( ! in_array($fileMimeType, $this->allowedMimeTypes) )
			{
				$this->error = "Invalid image type.";
				return false;
			}

			if($fileSize > $this->maxImageSizeInBytes)
			{
				$this->error = "Image size can't be higher than " . $this->maxImageSizeInMb . " Mbs.";
				return false;
			}

			return true;
		}

		public function getError()
		{
			return $this->error;
		}
	}
<?php

	namespace App\Services\Upload;

	use App\Entity\Notte;
	use App\Services\Upload\FileValidator;
	use Symfony\Component\HttpFoundation\File\UploadedFile;

	/** 
	 * Upload files to the server.
	 * 
	 * @author Alberto Vian - alberto@albertolabs.com
	 */
	class FileUpload
	{
		/**
		 * Files to upload to the server.
		 * @var Array
		 */
		private $files;

		public function __construct(Array $files, String $uploadDir)
		{
			$this->files 		= $files;
			$this->uploadDir 	= $uploadDir . ( new \DateTime() )->format("Y/m/d/");
		}

		/**
		 * Upload all files included in the array
		 *
		 * @return Array 	$uploadFiles 	Array with the uploaded files info
		 */
		public function uploadFiles()
		{
			$uploadedFiles = [];

			foreach ($this->files as $file) 
			{
				$uploadResult = $this->uploadSingleFile($file);

				if($uploadResult) 
				{
					$uploadFiles[] = $uploadResult;
				}
			}

			return $uploadFiles;
		}

		/** 
		 * Upload a single file to the server
		 *
		 * @param 	UploadedFile 	$file 	File to upload
		 * @return 	Array 			[type]	Array with the file upload result
		 */
		private function uploadSingleFile(UploadedFile $file)
		{
			// get file attributes
			$fileHash = $this->generateFileHash($file);

			// create temp dir
			if( ! file_exists($this->uploadDir) ) 
			{
				mkdir($this->uploadDir, 0777, true);
			}

			// check if filename already exists
			$filepath = $this->uploadDir . $fileHash;

			// move file to the upload dir
			try
			{
				$file->move($this->uploadDir, $fileHash);

				// TODO: create document entity

				return [
						'filepath' => $filepath,
						'fileInfo' => $file
					];
			}
			catch(\Exception $e)
			{
				// TODO: log error
				throw $e;
			}
		}

		/**
		 * Generate a unique hash for the file
		 *
		 * @return String   	Generate hash for the file.
		 */
		private function generateFileHash(UploadedFile $file)
		{
			// Get file attributes
			$originalFilename 	= $file->getClientOriginalName();
			$fileExtension 		= $file->guessExtension();
			$fileSize 			= $file->getClientSize();
			$currentDatetime 	= ( new \DateTime() )->format("YmdHis");

			// Generate hash string
			$hash = $originalFilename . "_" . $fileExtension . "_" . $fileSize . "_" . $currentDatetime;

			return hash('sha256', $hash);
		}
	}
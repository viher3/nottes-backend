<?php

	namespace App\Services\Upload;

	use App\Entity\Notte;
	use App\Services\Upload\FileSanitizer;
	use App\Services\Upload\FileValidator;

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

		public function __construct(Array $files)
		{
			$this->files = $files;
		}

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

		private function uploadSingleFile($file)
		{
			// get file attributes
			$filename 		= $file->getClientOriginalName();
			$newFilename 	= ( new FileSanitizer() )->sanitize($filename);

			// TODO: check if filename already exists.

			// create temp dir
			$uploadDir = $this->getParameter("uploadDir"); // TODO: set upload dir

			if( ! file_exists($uploadDir) ) mkdir($uploadDir, 0777, true);

			// move file to the upload dir
			try
			{
				$file->move($uploadDir, $newFilename);
				$filepath = $uploadDir . $newFilename;

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
	}
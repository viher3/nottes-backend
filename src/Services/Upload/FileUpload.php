<?php

	namespace App\Services\Upload;

	use App\Entity\Notte;
	use App\Entity\Document;
	use Doctrine\ORM\EntityManagerInterface;
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

		private $em;

		public function __construct(Array $files, EntityManagerInterface $em, String $uploadDir, $user)
		{
			$this->files 		= $files;
			$this->em 			= $em;
			$this->user 		= $user;
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

			try
			{
				// move file to the upload dir
				$file->move($this->uploadDir, $fileHash);

				// get short file path
				$filePathArray = explode("uploads/", $filepath);
				$shortFilepath = $filePathArray[1];

				// create entities
				$this->createDocumentEntity($file, $filepath, $shortFilepath);

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

		private function createDocumentEntity(UploadedFile $file, $filepath, $shortFilepath, $tags="")
		{
			$filename = $file->getClientOriginalName();

			// create notte entity
			$notte = new Notte();
			$notte->setName($filename);
			$notte->setType("file");
			$notte->setCreatorUser($this->user);

			if( ! empty($tags) )
			{
				$notte->setTags($tags);
			}

			// save notte entity
			$this->em->persist($notte);
			$this->em->flush();

			// create document entity
			$document = new Document();
			$document->setName($filename);
			$document->setPath($shortFilepath);
			$document->setNotte($notte);

			// get file size
			$size = filesize($filepath);
			$document->setSize($size);

			// get mimetype
			$mimetype = mime_content_type($filepath);
			$document->setMimetype($mimetype);

			// save document entity
			$this->em->persist($document);
			$this->em->flush();
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
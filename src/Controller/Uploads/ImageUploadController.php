<?php

	namespace App\Controller\Uploads;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;
	use App\Entity\Notte;
	use Aws\S3\S3Client;
	use Aws\S3\S3Exception;
	use App\Services\Upload\FileSanitizer;
	use App\Services\Upload\FileValidator;

	class ImageUploadController extends Controller
	{
		/**
	     * Upload an image
	     *
	     * @Route("/upload/image", name="upload_image", methods={"POST"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Upload an image"
	     * )
	     * @SWG\Tag(name="uploads")
	     */
		public function index(Request $request, S3Client $s3)
		{
			// get file object
			$file = $request->files->get("file");

			// get file attributes
			$filename 		= $file->getClientOriginalName();
			$newFilename 	= ( new FileSanitizer() )->sanitize($filename);

			// validate file
			$validator = new FileValidator();

			if( ! $validator->validateImage($file) )
			{
				return View::create(["error" => $validator->getError() ], Response::HTTP_INTERNAL_SERVER_ERROR, []);
			}

			// create temp dir
			$tempDir = $this->get("kernel")->getRootDir() . "/../public/temp/";

			if( ! file_exists($tempDir) ) mkdir($tempDir, 0777, true);

			// move file to temp dir
			if( $file->move($tempDir, $filename) )
			{
				$filepath = $tempDir . $filename;

				try
				{
					// upload to object storage
					$insert = $s3->putObject([
						'Bucket' => 'reaccionestudio1',
						'Key' 	 => 'nottes/' . $newFilename,
						'Body' 	 => fopen($filepath, "r"),
						'ACL'    => 'public-read'
					]);

					// delete temp file
					unlink($filepath);
				} 
				catch (Aws\S3\Exception\S3Exception $e) 
				{
					return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, []);
				}
			}

    		return View::create($insert, Response::HTTP_OK, []);
		}
	}
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
	use App\Services\Upload\FileSanitizer;
	use App\Services\Upload\FileValidator;

	class FileUploadController extends Controller
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
		public function index(Request $request)
		{
			$result = [];

			// get file object
			$file = $request->files->get("file");

			// get file attributes
			$filename 		= $file->getClientOriginalName();
			$newFilename 	= ( new FileSanitizer() )->sanitize($filename);

			// TODO: check if filename already exists.

			// validate file
			$validator = new FileValidator();

			if( ! $validator->validateImage($file) )
			{
				return  View::create(
							["error" => $validator->getError()], 
							Response::HTTP_INTERNAL_SERVER_ERROR, []
						);
			}

			// create temp dir
			$uploadDir = $this->getParameter("uploadDir");

			if( ! file_exists($uploadDir) ) mkdir($uploadDir, 0777, true);

			// move file to the upload dir
			try
			{
				$file->move($uploadDir, $filename);
				$filepath = $uploadDir . $filename;

				$result = [
							'filepath' => $filepath,
							'fileInfo' => $file
						  ];
			}
			catch(\Exception $e)
			{
				return 	View::create(
							["error" => $e->getError()],
				 			Response::HTTP_INTERNAL_SERVER_ERROR, []
				 		);
			}

			return View::create($result, Response::HTTP_OK, []);
		}
	}
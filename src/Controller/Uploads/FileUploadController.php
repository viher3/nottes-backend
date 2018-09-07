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
	use App\Services\Upload\FileUpload;

	class FileUploadController extends Controller
	{
		/**
	     * Upload an image
	     *
	     * @Route("/api/upload", name="upload_image", methods={"POST"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Upload an image"
	     * )
	     * @SWG\Tag(name="uploads")
	     */
		public function index(Request $request)
		{
			// get files array
			$files = $request->files->get('files');

			// FileUpload service
			$fileUpload = new FileUpload($files);
			$result = $fileUpload->uploadFiles();

			return View::create($result, Response::HTTP_OK, []);
		}
	}
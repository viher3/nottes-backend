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

	class ImageUploadController extends Controller
	{
		/**
	     * Upload an image
	     *
	     * @Route("/upload/image", name="upload_image", methods={"GET"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Upload an image"
	     * )
	     * @SWG\Tag(name="uploads")
	     */
		public function index(Request $request, S3Client $s3)
		{
			$spaces = $s3->listBuckets();
			
    		return View::create($spaces, Response::HTTP_OK, []);
		}
	}
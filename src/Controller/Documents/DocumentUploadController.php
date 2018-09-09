<?php

	namespace App\Controller\Documents;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;
	use App\Entity\Notte;
	use App\Services\Upload\FileUpload;

	class DocumentUploadController extends Controller
	{
		/**
	     * Upload file/s
	     *
	     * @Route("/api/document", name="upload_document", methods={"POST"}).
	     *
	     * @SWG\Parameter(
         *     name="files",
         *     in="query",
         *     type="string",
         *     required=true,
         *     description="Array with File objects to upload"
         * )
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Upload file/s"
	     * )
	     * @SWG\Tag(name="documents")
	     */
		public function index(Request $request)
		{
			// get files array
			$files = $request->files->get('files');

			// FileUpload service
			$fileUpload = new FileUpload(
								$files, 
								$this->getDoctrine()->getManager(),
								$this->getParameter("uploadDir"),
								$this->get('jwt.user.manager')->getUser()
							);
			$result = $fileUpload->uploadFiles();

			return View::create($result, Response::HTTP_OK, []);
		}
	}
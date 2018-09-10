<?php

	namespace App\Controller\Documents;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\BinaryFileResponse;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use Symfony\Component\HttpFoundation\ResponseHeaderBag;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;

	use App\Entity\Document;

	class DocumentDownloadController extends Controller
	{
		/**
	     * Download file
	     *
	     * @Route("/api/document/{id}", name="download_document", methods={"GET"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Download file/document"
	     * )
	     * @SWG\Tag(name="documents")
	     */
		public function index(Document $entity)
		{
			if(empty($entity))
			{
				throw new NotFoundHttpException("Entity not found");
			}

			// check entity owner
			$currentUser = $this->get('jwt.user.manager')->getUser();

			if($entity->getCreatorUser()->getId() != $currentUser->getId())
			{
				return View::create(['error' => 'Forbidden access'], Response::HTTP_FORBIDDEN, []);
			}

			// get file
			$filename = $entity->getName();
			$filepath = $entity->getPath();
			$fullFilepath = $this->getParameter("uploadDir") . $filepath;

			if( ! file_exists($fullFilepath) )
			{
				throw new NotFoundHttpException("File not found");
			}

			// create the response object
			$response = new BinaryFileResponse($fullFilepath);

			// set file MimeType
			if( ! empty($entity->getMimetype()) ) 
			{
	           	$response->headers->set('Content-Type', $entity->getMimetype());
	       	}
	       	else 
	       	{
	           	$response->headers->set('Content-Type', 'text/plain');
	       	}

	       	// Set content disposition inline of the file
	       	$response->setContentDisposition(
	           ResponseHeaderBag::DISPOSITION_ATTACHMENT,
	           $filename
	       	);

			return $response;
		}
	}

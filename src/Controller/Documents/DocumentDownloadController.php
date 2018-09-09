<?php

	namespace App\Controller\Documents;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

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
			$result = [];

			return View::create($result, Response::HTTP_OK, []);
		}
	}

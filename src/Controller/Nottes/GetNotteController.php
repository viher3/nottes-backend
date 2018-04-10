<?php

	namespace App\Controller\Nottes;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;
	use App\Entity\Notte;

	class GetNotteController extends Controller
	{
		/**
	     * Get a notte
	     *
	     * @Route("/api/notte/{id}", name="nottes_get", methods={"GET"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return the notte entity object"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index(Notte $notte)
		{
			return View::create($notte, Response::HTTP_OK, []);
		}
	}
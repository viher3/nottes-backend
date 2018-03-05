<?php

	namespace App\Controller\Nottes;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;

	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;

	class CreateNotteController extends Controller
	{
		/**
	     * Create a new notte
	     *
	     * @Route("/api/notte", name="nottes_get", methods={"POST"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Returns the created notte"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index()
		{
			return $this->handleView( $this->view( ['hola'] , 200 ) );
		}
	}
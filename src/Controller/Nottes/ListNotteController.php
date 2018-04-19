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

	class ListNotteController extends Controller
	{
		/**
	     * Get all user nottes
	     *
	     * @Route("/api/notte", name="nottes_list", methods={"GET"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return all user notte entities"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index(Request $request)
		{
			$user = $this->get("jwt.user.manager")->getUser();

			// get docs
			$em = $this->getDoctrine()->getManager();
			$nottes = $em->getRepository(Notte::class)->getList($user);

			// pagination
			$paginator  = $this->get('knp_paginator');
		    $nottes = $paginator->paginate(
		        $nottes,
		        $request->query->get("page"),
		        $this->getParameter("pagination_page_limit")
		    );

			return View::create($nottes, Response::HTTP_OK, []);
		}
	}
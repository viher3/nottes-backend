<?php

	namespace App\Controller\Nottes;

	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;

	use FOS\RestBundle\Controller\FOSRestController;
	use FOS\RestBundle\Context\Context;
	use FOS\RestBundle\View\View;
	use Swagger\Annotations as SWG;

	use App\Entity\Notte;

	class ListNotteController extends FOSRestController
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
			//$nottes = $em->getRepository(Notte::class)->getList($user);
			$nottes = $em->getRepository(Notte::class)->findAll();

			// TODO: knp_paginator breaks the serializer group

			// pagination
			/*
			$paginator  = $this->get('knp_paginator');
		    $nottes = $paginator->paginate(
		        $nottes,
		        $request->query->get("page"),
		        $this->getParameter("pagination_page_limit")
		    );
		    */

		    // generate view
			$view = View::create();
			
			$context = new Context();
			$context->setGroups(['notteList']);
			$view->setContext($context);
			
			$view->setData($nottes);

			return $this->handleView($view);
		}
	}
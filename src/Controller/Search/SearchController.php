<?php

	namespace App\Controller\Search;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;

	class SearchController extends Controller
	{
		/**
	     * Search a term
	     *
	     * @Route("api/search/{q}", name="nottes_search", methods={"GET"}).
         *
		 * @SWG\Parameter(
         *     name="p",
         *     in="query",
         *     type="integer",
         *     description="Current page"
         * )
		 *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Search request"
	     * )
	     * @SWG\Tag(name="search")
	     */
		public function index(string $q, Request $request)
		{
			$page = ! empty( $request->query->get("p") ) ? $request->query->get("p") : 1;
			
			try
			{
				// encode search term
				$q = urlencode($q);

				// search
				$result = $this->get("search")->searchTerm($q);

				// pagination
				$paginator  = $this->get('knp_paginator');
			    $result = $paginator->paginate(
			        $result,
			        intval($page),
			        $this->getParameter("pagination_page_limit")
			    );

			}
			catch(\Exception $e)
			{
				return View::create(["error" => $e->getMessage() ], Response::HTTP_INTERNAL_SERVER_ERROR, []);
			}
			
			return View::create($result, Response::HTTP_OK, []);
		}
	}
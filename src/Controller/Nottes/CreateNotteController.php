<?php

	namespace App\Controller\Nottes;

	use FOS\RestBundle\Controller\Annotations\Post;
	use FOS\RestBundle\Controller\FOSRestController;
	use FOS\RestBundle\Controller\Annotations\RequestParam;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

	use Swagger\Annotations as SWG;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Symfony\Component\Routing\Annotation\Route;

	class CreateNotteController
	{
		/*
	     * List the rewards of the specified user.
	     *
	     * This call takes into account all confirmed awards, but not pending or refused awards.
	     *
	     * @Route("/api/nottes", methods={"GET"})
	     * @SWG\Response(
	     *     response=200,
	     *     description="Returns the rewards of an user"
	     * )
	     * @SWG\Parameter(
	     *     name="order",
	     *     in="query",
	     *     type="string",
	     *     description="The field used to order rewards"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index()
		{
			return $this->handleView( $this->view( ['hola'] , 200 ) );
		}
	}
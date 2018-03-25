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
	     *     description="Returns all user nottes"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index()
		{
			$user = $this->get("jwt.user.manager")->getUser();

			$em = $this->getDoctrine()->getManager();
			$nottes = $em->getRepository(Notte::class)->findBy(
				[
					"creatorUser" => $user
				]
			);

			return View::create($nottes, Response::HTTP_OK, []);
		}
	}
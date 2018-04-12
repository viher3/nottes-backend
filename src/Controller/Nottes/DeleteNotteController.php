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

	class DeleteNotteController extends Controller
	{
		/**
	     * Delete user notte
	     *
	     * @Route("/api/notte/{id}", name="nottes_delete", methods={"DELETE"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Delete user notte"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index(Notte $id)
		{
			$em = $this->getDoctrine()->getManager();

			// check creator user
			$currentUser = $this->get('jwt.user.manager')->getUser();

			if( $currentUser != $id->getCreatorUser() )
			{
				return View::create("HTTP_UNAUTHORIZED", Response::HTTP_UNAUTHORIZED, []);
			}

			// remove
			try
			{
				$em->remove($id);
				$em->flush();
			}
			catch(\Exception $e)
			{
				return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, []);
			}

			return View::create([], Response::HTTP_OK, []);
		}
	}
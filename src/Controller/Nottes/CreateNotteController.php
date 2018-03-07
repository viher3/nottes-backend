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
		public function index(Request $request)
		{
			// get post data
    		$notte = new Notte();
    		$postData = $request->request->all();

    		// get form
    		$form = $this->createForm( 'App\Form\NotteType', $notte);
    		$form->setData( $notte );
    		$form->submit( $postData );

    		if( $form->isSubmitted() && $form->isValid() )
    		{
    			$ret = ['IS_VALID'];
    		}
    		else
    		{
    			$ret = ['IS_NOT_VALID'];
    		}

    		return View::create($ret, Response::HTTP_OK , []);
		}
	}
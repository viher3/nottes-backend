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
	     * @Route("/api/notte", name="nottes_create", methods={"POST"}).
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Create a new notte"
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
    			$em	= $this->getDoctrine()->getManager();
    			
    			try
    			{
    				$notte->setCreatorUser( 
    					$this->get('jwt.user.manager')->getUser()
    				);

    				$em->persist($notte);
        			$em->flush($notte);

        			return View::create($notte, Response::HTTP_OK , []);
    			}
    			catch(\Exception $e)
    			{
    				return View::create(
    					[ 
    						'ERROR' => 'SAVING_DATA', 
    						'MESSAGES' => $e->getMessage() 
    					], 
    					Response::HTTP_INTERNAL_SERVER_ERROR , 
    					[]
    				);
    			}
    		}
    		else
    		{
    			return View::create($form->getErrors(), Response::HTTP_INTERNAL_SERVER_ERROR, []);
    		}
		}
	}
<?php

	namespace App\Controller\Links;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;
	use App\Entity\Notte;

	class CreateLinkController extends Controller
	{
		/**
	     * Create a new link
	     *
	     * @Route("/api/link", name="link_create", methods={"POST"}).
	     *
         * @SWG\Parameter(
         *     name="name",
         *     in="query",
         *     type="string",
         *     description="Link name or title"
         * )
         * @SWG\Parameter(
         *     name="content",
         *     in="query",
         *     type="string",
         *     description="Link url"
         * )
         * @SWG\Parameter(
         *     name="tags",
         *     in="query",
         *     type="string",
         *     description="Link tags separated by comma"
         * )
         *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return the notte entity object (link)"
	     * )
	     * @SWG\Tag(name="links")
	     */
		public function index(Request $request)
		{
    		$link = new Notte();

			// get post data
    		$postData = $request->request->all();

    		// get form
    		$form = $this->createForm( 'App\Form\Link\LinkType', $link);
    		$form->setData($link);
    		$form->submit($postData);

    		if( $form->isSubmitted() && $form->isValid() )
    		{
    			$em	= $this->getDoctrine()->getManager();

    			try
    			{
    				$link->setType("link");

	    			// save data
					$em->persist($link);
	    			$em->flush($link);
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

    			return View::create($link, Response::HTTP_OK , []);
    		}
    		else
    		{
    			return View::create($form->getErrors(), Response::HTTP_INTERNAL_SERVER_ERROR, []);
    		}
		}
	}
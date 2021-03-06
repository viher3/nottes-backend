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
    use App\Services\Encryption\Encryption;

	class UpdateNotteController extends Controller
	{
		/**
	     * Update existing notte
	     *
	     * @Route("/api/notte/{id}", name="nottes_update", methods={"PUT"}).
	     *
         * @SWG\Parameter(
         *     name="name",
         *     in="query",
         *     type="string",
         *     description="Document name or title"
         * )
         * @SWG\Parameter(
         *     name="content",
         *     in="query",
         *     type="string",
         *     description="Document content"
         * )
         * @SWG\Parameter(
         *     name="tags",
         *     in="query",
         *     type="string",
         *     description="Document tags separated by comma"
         * )
         * @SWG\Parameter(
         *     name="isEncrypted",
         *     in="query",
         *     type="boolean",
         *     description="If document is encrypted"
         * )
         * @SWG\Parameter(
         *     name="encryptionPassword",
         *     in="query",
         *     type="string",
         *     description="Encryption password"
         * )
         *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return the notte entity object"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index(Notte $notte, Request $request)
		{
            $em = $this->getDoctrine()->getManager();

            // check creator user
            $currentUser = $this->get('jwt.user.manager')->getUser();

            if( $currentUser != $notte->getCreatorUser() )
            {
                return View::create("HTTP_UNAUTHORIZED", Response::HTTP_UNAUTHORIZED, []);
            }

			// get post data
    		$postData = $request->request->all();

    		// get form
    		$form = $this->createForm( 'App\Form\Notte\NotteType', $notte);
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

                    // check if we need to encrypt the document
                    if( $request->request->get("isEncrypted") )
                    {
                        $encryption = new Encryption();
                        $encryptionResult = $encryption->encrypt(
                                                $notte->getContent(), 
                                                $request->request->get("encryptionpwd2")
                                            );

                        $notte->setContent($encryptionResult);
                    }

                    // save data
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
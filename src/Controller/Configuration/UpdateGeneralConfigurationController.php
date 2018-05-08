<?php

	namespace App\Controller\Configuration;

	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	use FOS\RestBundle\View\View;
	use Nelmio\ApiDocBundle\Annotation\Model;
	use Swagger\Annotations as SWG;

	class UpdateGeneralConfigurationController extends Controller
	{
		/**
	     * Update general configuration for current user
	     *
	     * @Route("/api/configuration/general", name="general_configuration", methods={"PUT"}).
	     *
         * @SWG\Parameter(
         *     name="nickname",
         *     in="query",
         *     type="string",
         *     description="User nickname"
         * )
         * @SWG\Parameter(
         *     name="email",
         *     in="query",
         *     type="string",
         *     description="User email"
         * )
         * @SWG\Parameter(
         *     name="language",
         *     in="query",
         *     type="string",
         *     description="App language for the user"
         * )
         * @SWG\Parameter(
         *     name="password",
         *     in="query",
         *     type="boolean",
         *     description="User account password"
         * )
         *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return the configuration object"
	     * )
	     * @SWG\Tag(name="configuration")
	     */
		public function index(Request $request)
		{
            // get user
            $currentUser = $this->get('jwt.user.manager')->getUser();

            // get post data
            $postData = $request->request->all();

            // create form
            $form = $this->createForm('App\Form\Configuration\GeneralConfigurationType');
            $form->submit( $postData );

            // form input validation
            if( $form->isSubmitted() && ! $form->isValid() )
            {
                return View::create($form->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY, []);
            }

            // check if user confirmation password is correct
            $confirmationPassword = $request->request->get("password");

            $passwordIsValid = $this->get("validate.user.password")->passwordIsValid($confirmationPassword);

            if( ! $passwordIsValid )
            {
                return View::create(["error" => "invalid_password" ], Response::HTTP_INTERNAL_SERVER_ERROR, []);
            }

            // save form data
    		$em	= $this->getDoctrine()->getManager();

            // update entity fields
            try
            {
                $currentUser->setNickname($form['nickname']->getData());
                $currentUser->setLanguage($form['language']->getData());
                $currentUser->setEmail($form['email']->getData());
                $currentUser->setEmailCanonical($form['email']->getData());

                // update user
                $userManager = $this->container->get('fos_user.user_manager');
                $userManager->updateUser($currentUser, true);
            }
            catch(\Exception $e)
            {
                return View::create(
                    [ 'error' => $e->getMessage() ], 
                    Response::HTTP_INTERNAL_SERVER_ERROR, 
                    []
                );
            }
            
            return View::create($currentUser, Response::HTTP_OK, []);
		}
	}
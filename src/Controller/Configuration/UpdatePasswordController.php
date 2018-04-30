<?php

namespace App\Controller\Configuration;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UpdatePasswordController extends Controller
{
	/**
     * Update current user account password
     *
     * @Route("/api/configuration/security/password", name="security_password_configuration", methods={"PUT"}).
     *
     * @SWG\Parameter(
     *     name="currentPassword",
     *     in="query",
     *     type="string",
     *     description="Current user password"
     * )
     * @SWG\Parameter(
     *     name="newPassword",
     *     in="query",
     *     type="string",
     *     description="New user password"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Return user entity"
     * )
     * @SWG\Tag(name="configuration")
     */
	public function index(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        // get user
        $currentUser = $this->get('jwt.user.manager')->getUser();

        // create form
        $form = $this->createForm('App\Form\Configuration\UpdatePasswordType');
        $form->submit( $request->request->all() );

        // form input validation
        if( $form->isSubmitted() && ! $form->isValid() )
        {
            return View::create($form->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY, []);
        }

        // check if current user password is valid
        $currentPassword = $form["currentPassword"]->getData();

        $passwordIsValid = $this->get("validate.user.password")->passwordIsValid($currentPassword);

        if( ! $passwordIsValid )
        {
            return View::create(["error" => "invalid_password" ], Response::HTTP_INTERNAL_SERVER_ERROR, []);
        }

		try
		{
			// update password
			$newPassword = $form["newPassword"]->getData();
			$currentUser->setPlainPassword($newPassword);

			// save data
	        $userManager = $this->container->get('fos_user.user_manager');
	        $userManager->updateUser($currentUser, true);
		}
		catch(\Exception $e)
		{
			return View::create([ "error" => $e->getMessage() ], Response::HTTP_INTERNAL_SERVER_ERROR, []);	
		}

        return View::create($currentUser, Response::HTTP_OK, []);
	}
}
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
	use App\Services\Editor\BBCodeCompiler;

	class GetNotteController extends Controller
	{
		/**
	     * Get a notte
	     *
	     * @Route("/api/notte/{id}", name="nottes_get", methods={"GET"}).
	     *
	     * @SWG\Parameter(
         *     name="format",
         *     in="query",
         *     type="string",
         *     description="Return content format as specified in the parameter. Possible values: html "
         * )
         *
	     * @SWG\Parameter(
         *     name="pwd",
         *     in="query",
         *     type="string",
         *     description="Document encryption password. (Only if document is encrypted)."
         * )
	     *
	     * @SWG\Response(
	     *     response=200,
	     *     description="Return the notte entity object"
	     * )
	     * @SWG\Tag(name="nottes")
	     */
		public function index(Request $request, Notte $notte)
		{
			// check creator user
			$currentUser = $this->get('jwt.user.manager')->getUser();
			
			if( $currentUser != $notte->getCreatorUser() )
			{
				return View::create("HTTP_UNAUTHORIZED", Response::HTTP_UNAUTHORIZED, []);
			}

			if( $notte->isEncrypted() && $request->query->get("pwd") )
			{
				try
				{
					$encryptionPwd = $request->query->get("pwd");
					$encryptionPwd = ( $this->isBase64($encryptionPwd) )
									 ? base64_decode($encryptionPwd)
									 : $encryptionPwd;

					$encryption = new Encryption();
					$decryptedContent = $encryption->decrypt(
						$notte->getContent(),
						$encryptionPwd
					);

					// add new content to the entity
					$notte->setContent($decryptedContent);
					$notte->isDecrypted(true);
				}
				catch(\Exception $e)
				{
					$errMssg = $e->getMessage();

					if($e->getMessage() == "Integrity check failed.") 
					{
						$errMssg = ["error" => "wrong_encryption_password"];
					}

					return View::create($errMssg, Response::HTTP_INTERNAL_SERVER_ERROR, []);
				}
			}

			/*
			if( $request->query->get("format") == "html" )
			{
				// convert BBCode to HTML
				$content = ( new BBCodeCompiler( $notte->getContent() ) )->toHtml();

				// add new content to the entity
				$notte->setContent($content);
			}
			*/

			return View::create($notte, Response::HTTP_OK, []);
		}

		private function isBase64(string $str)
		{
			return ( ( base64_encode( base64_decode($str, true) ) === $str) ) ? true : false;
		}
	}
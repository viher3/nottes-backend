<?php

	namespace App\Services\User\EventListener;

	use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
	use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
	use Symfony\Component\HttpFoundation\RequestStack;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Services\User\SaveUserInfoToLog;

	class AuthenticationFailureListener
	{
		/**
		 * @var RequestStack
		 */
		private $requestStack;

		/**
		 * @var EntityManagerInterface
		 */
		private $em;

		/**
		 * @param RequestStack $requestStack
		 */
		public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
		{
		    $this->em = $em;
		    $this->requestStack = $requestStack;
		}

		/**
		 * @param AuthenticationFailureEvent $event
		 */
		public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
		{
		    // save user info into login log
		    $request = $this->requestStack->getCurrentRequest();
		    $email = $request->request->get("_username");

		    $saveUserInfoToLog = new SaveUserInfoToLog($this->em);
		    $saveUserInfoToLog->saveUserInfo($email, true);
		    
		    // set response
		    $data = [
		        'status'  => '401 Unauthorized',
		        'message' => 'bad_credentials',
		    ];

		    $response = new JWTAuthenticationFailureResponse($data);

		    $event->setResponse($response);
		}

	}
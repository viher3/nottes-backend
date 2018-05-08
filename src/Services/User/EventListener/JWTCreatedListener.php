<?php

	namespace App\Services\User\EventListener;

	use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
	use Symfony\Component\HttpFoundation\RequestStack;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Entity\User;
	use App\Services\User\SaveUserInfoToLog;

	class JWTCreatedListener
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
		 * @param JWTCreatedEvent $event
		 *
		 * @return void
		 */
		public function onJWTCreated(JWTCreatedEvent $event)
		{
		    $request = $this->requestStack->getCurrentRequest();

		    // get payload data
		    $payload = $event->getData();

		    // get user object
		    $user = $this->em->getRepository(User::class)->findOneBy(
		    	[ 'username' => $payload['username'] ]
		    );

		    // add new data to the payload
		    $payload['language'] = $user->getLanguage();
		    $payload['nickname'] = $user->getNickname();
		    $payload['email'] 	 = $user->getEmail();
		    
		    // save data payload
		    $event->setData($payload);

		    // save user info into login log
		    $saveUserInfoToLog = new SaveUserInfoToLog($this->em);
		    $saveUserInfoToLog->saveUserInfo($user->getEmail(), true);
		}
	}
<?php

	namespace App\Services\User\Validation;
	
	class ValidateUserPassword
	{
		private $tokenStorage;
		private $userManager;
		private $encoderFactory;

		public function __construct($tokenStorage, $userManager, $encoderFactory)
		{
			$this->tokenStorage 	= $tokenStorage;
			$this->userManager 		= $userManager;
			$this->encoderFactory 	= $encoderFactory;
		}

		public function passwordIsValid( String $password)
		{
			$objCurrentUser = $this->tokenStorage->getToken()->getUser();

			if( empty($objCurrentUser) ) return false;

	        // find user
	        $user       = $this->userManager->findUserByUsername( $objCurrentUser->getUsername() );
	        $encoder    = $this->encoderFactory->getEncoder($user);

	        if( $encoder->isPasswordValid( $user->getPassword(), $password, $user->getSalt() ) ) 
	        {
	        	return true;
	        }

			return false;
		}
	}
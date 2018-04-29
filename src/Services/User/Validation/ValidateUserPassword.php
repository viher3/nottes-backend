<?php

	namespace App\Services\User\Validation;
	
	use App\Services\User\JwtUserManager;

	class ValidateUserPassword
	{
		private $jwtUserManager;
		private $fosUserManager;
		private $encoderFactory;

		public function __construct(JwtUserManager $jwtUserManager, $fosUserManager, $encoderFactory)
		{
			$this->jwtUserManager 	= $jwtUserManager;
			$this->userManager 		= $fosUserManager;
			$this->encoderFactory 	= $encoderFactory;
		}

		public function passwordIsValid( String $password)
		{
			$currentUser = $this->jwtUserManager->getUser();

			if( empty($currentUser) ) return false;

	        $encoder = $this->encoderFactory->getEncoder($currentUser);

	        if( $encoder->isPasswordValid( $currentUser->getPassword(), $password, $currentUser->getSalt() ) ) 
	        {
	        	return true;
	        }

			return false;
		}
	}
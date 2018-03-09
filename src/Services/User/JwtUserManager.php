<?php

	namespace App\Services\User;

	use App\Entity\User;

	final class JwtUserManager
	{
		private $em;
		private $tokenStorage;
		private $jwtAuthEncoder;

		public function __construct($em, $tokenStorage, $jwtAuthEncoder)
		{
			$this->em 				= $em;
			$this->tokenStorage 	= $tokenStorage;
			$this->jwtAuthEncoder 	= $jwtAuthEncoder;
		}

		public function getUser()
		{
			$token 		= $this->tokenStorage->getToken()->getCredentials();
			$arrUser 	= $this->jwtAuthEncoder->decode($token);
			
			if( empty($arrUser['username']) )
			{
				throw new \Exception("Username is empty in JWT token.");
			}

			// find user on db
			$objUser = $this->em->getRepository(User::class)->findOneBy(
				[
					"username" => $arrUser["username"]
				]
			);

			if( empty($objUser) )
			{
				throw new \Exception("User not found in database.");
			}

			return $objUser;
		}
	}
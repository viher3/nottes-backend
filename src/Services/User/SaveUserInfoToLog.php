<?php

	namespace App\Services\User;

	use App\Entity\User;
	use App\Entity\UserAccess;
	use Doctrine\ORM\EntityManagerInterface;

	class SaveUserInfoToLog
	{
		private $em;

		public function __construct(EntityManagerInterface $em)
		{
			$this->em = $em;
		}

		public function saveUserInfo(string $email, bool $isSuccessfulLogin)
		{
			$userAccess = new UserAccess();
			$userAccess->setEmail($email);
			$userAccess->setIp( $this->getClientIp() );
			$userAccess->setUserAgent( $this->getUserAgent() );
			$userAccess->setSuccessfulLogin($isSuccessfulLogin);
			$userAccess->setTime( new \DateTime() );

			$this->em->persist($userAccess);
			$this->em->flush();
		}

		private function getUserAgent()
		{
			return $_SERVER['HTTP_USER_AGENT'];
		}

		private function getClientIp() 
		{
			$ip = "unknown";

		    if( ! empty($_SERVER['HTTP_CLIENT_IP']))
		    {
		        //ip from share internet
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    }
		    elseif( ! empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		    {
		        //ip pass from proxy
		        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }
		    else
		    {
		        $ip = $_SERVER['REMOTE_ADDR'];
		    }
		    
		    return $ip;
		}
	}
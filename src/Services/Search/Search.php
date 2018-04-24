<?php

	namespace App\Services\Search;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Services\User\JwtUserManager;

	class Search
	{
		private $em;

		public function __construct(EntityManagerInterface $em, JwtUserManager $userManager)
		{
			$this->em 	= $em;
			$this->user = $userManager->getUser();
		}

		public function searchTerm($term)
		{
			if( empty($term) ) return [];

			$dql =  "
					SELECT 
					d.id, 
					d.name, 
					d.tags
					FROM App\Entity\Notte d
					LEFT JOIN d.creatorUser u 
					WHERE u = :creatorUser
					AND
					(
						d.name LIKE :searchTerm
						OR 
						d.tags LIKE :searchTerm 
						OR 
						d.content LIKE :searchTerm
					)
					";

			$query = $this->em
                    	->createQuery($dql)
                    	->setParameter('creatorUser', $this->user )
                    	->setParameter('searchTerm', "%" . $term . "%");

			return $query->getResult();
		}
	}
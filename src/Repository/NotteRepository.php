<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Notte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Notte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notte[]    findAll()
 * @method Notte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Notte[]    getList(User $creatorUser)
 */
class NotteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notte::class);
    }

    public function getList(User $creatorUser)
    {
        $entityManager = $this->getEntityManager();

        $dql =  "
                SELECT d
                FROM App\Entity\Notte d 
                WHERE d.creatorUser = :creatorUser 
                ORDER BY d.id DESC
                ";

        $query = $entityManager
                    ->createQuery($dql)
                    ->setParameter('creatorUser', $creatorUser);

        return $query->getResult();
    }

}

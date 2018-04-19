<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Notte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notte[]    findAll()
 * @method Notte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Notte[]    getList(User $creatorUser)
 */
class NotteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notte::class);
    }

    public function getList(User $creatorUser)
    {
        $entityManager = $this->getEntityManager();

        $dql =  "
                SELECT 
                d.id,
                d.name,
                d.tags, 
                d.isEncrypted,
                u.id AS creatorUserId,
                u.username AS creatorUsername,
                d.updatedAt
                FROM App\Entity\Notte d 
                LEFT JOIN d.creatorUser u 
                WHERE d.creatorUser = :creatorUser 
                ORDER BY d.id DESC
                ";

        $query = $entityManager
                    ->createQuery($dql)
                    ->setParameter('creatorUser', $creatorUser);

        return $query->getResult();
    }

}

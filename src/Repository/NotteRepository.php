<?php

namespace App\Repository;

use App\Entity\Notte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notte[]    findAll()
 * @method Notte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notte::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('n')
            ->where('n.something = :value')->setParameter('value', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}

<?php

namespace App\Nottes\Infrastructure\Text\Persistence;

use App\Nottes\Domain\Text\Text;
use Doctrine\ORM\EntityRepository;
use App\Nottes\Domain\Text\TextId;
use App\Nottes\Domain\Text\TextRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineTextRepository extends DoctrineRepository implements TextRepository
{
    public function search() : array
    {
        $qb = $this->getRepository()->createQueryBuilder('q');
        return $qb->getQuery()->getResult();
    }

    public function find(TextId $id): ?Text
    {
        return $this->getRepository()->find($id);
    }

    public function save(Text $Text) : void
    {
        $this->persist($Text);
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(Text::class);
    }
}

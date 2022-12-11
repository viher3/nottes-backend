<?php

namespace App\Nottes\Infrastructure\Folder\Persistence;

use Doctrine\ORM\EntityRepository;
use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
use App\Nottes\Domain\Folder\FolderRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineFolderRepository extends DoctrineRepository implements FolderRepository
{
    public function search() : array
    {
        $qb = $this->getRepository()->createQueryBuilder('q');
        return $qb->getQuery()->getResult();
    }

    public function find(FolderId $id): ?Folder
    {
        return $this->getRepository()->find($id);
    }

    public function save(Folder $folder) : void
    {
        $this->persist($folder);
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(Folder::class);
    }
}

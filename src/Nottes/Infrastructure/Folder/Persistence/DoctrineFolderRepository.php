<?php

namespace App\Nottes\Infrastructure\Folder\Persistence;

use Doctrine\ORM\EntityRepository;
use App\Nottes\Domain\Folder\Folder;
use App\Nottes\Domain\Folder\FolderId;
use App\Shared\Domain\Criteria\Criteria;
use App\Nottes\Domain\Folder\FolderRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;

class DoctrineFolderRepository extends DoctrineRepository implements FolderRepository
{
    /**
     * @return array
     */
    public function search() : array
    {
        $qb = $this->getRepository()->createQueryBuilder('q');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param FolderId $id
     * @return Folder|null
     */
    public function find(FolderId $id): ?Folder
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param Folder $folder
     * @return void
     */
    public function save(Folder $folder) : void
    {
        $this->persist($folder);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository() : EntityRepository
    {
        return $this->repository(Folder::class);
    }
}

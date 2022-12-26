<?php

namespace App\Nottes\Domain\Folder;
use App\Shared\Domain\Criteria\Criteria;

interface FolderRepository
{
    /**
     * @param FolderId $id
     * @return Folder|null
     */
    public function find(FolderId $id): ?Folder;

    /**
     * @param Folder $folder
     * @return void
     */
    public function save(Folder $folder) : void;

    /**
     * @param Criteria $criteria
     * @return array
     */
    public function matching(Criteria $criteria): array;

    /**
     * @return Folder
     */
    public function findRoot() : Folder;
}

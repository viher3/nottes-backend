<?php

namespace App\Nottes\Domain\Folder;
use App\Shared\Domain\Criteria\Criteria;

interface FolderRepository
{
    public function find(FolderId $id): ?Folder;

    public function save(Folder $folder) : void;

    public function matching(Criteria $criteria): array;
}
